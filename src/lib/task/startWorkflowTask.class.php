<?php
/**
 *
 * The Task can be called in DEV and PROD environment, by default productive system is loaded
 *
 * setenvironment: "" = Productive system,
 *                 "cuteflow_dev.php" = DEV System
 *
 * call task: php symfony calculateUserAgent --setenvironment="" --host="http://cuteflow"
 *
 */

class startWorkflowTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'cuteflow'),
      new sfCommandOption('setenvironment', null, sfCommandOption::PARAMETER_REQUIRED, 'The real environment', ''),
     new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', ''),
      new sfCommandOption('host', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'http://cuteflow'), // http://cuteflow is default
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'startWorkflow';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [startWorkflow|INFO] task does things.
Call it with:

  [php symfony startWorkflow|INFO]
EOF;
  }

    protected function execute($arguments = array(), $options = array()) {
        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();
        $context = sfContext::createInstance($this->configuration);
        sfProjectConfiguration::getActive()->loadHelpers('Partial', 'I18N', 'Url');
        $serverUrl = $options['setenvironment'] == '' ? $serverUrl = $options['host'] : $serverUrl = $options['host'] . '/' . $options['setenvironment'];
        $workflows = WorkflowVersionTable::instance()->getWorkflowsToStart(time())->toArray();
        foreach($workflows as $workflow) {
            $sender = WorkflowTemplateTable::instance()->getWorkflowTemplateById($workflow['workflow_template_id'])->toArray();
            $userSettings = new UserMailSettings($sender[0]['sender_id']);
            $sendMail = new SendStartWorkflowEmail($userSettings, $context, $workflow, $sender, $serverUrl);
            $workflowTemplate = WorkflowTemplateTable::instance()->getWorkflowTemplateByVersionId($workflow['id']);
            WorkflowVersionTable::instance()->startWorkflowInFuture($workflow['id']);
            $sendToAllSlotsAtOnce = $workflowTemplate[0]->getMailinglistVersion()->toArray();
            if($sendToAllSlotsAtOnce[0]['send_to_all_slots_at_once'] == 1) {
                $calc = new CreateWorkflow($workflow['id']);
                $calc->setServerUrl($serverUrl);
                $calc->setContext($context);
                $calc->addAllSlots();
            }
            else {
                $calc = new CreateWorkflow($workflow['id']);
                $calc->setServerUrl($serverUrl);
                $calc->setContext($context);
                $calc->addSingleSlot();
            }

        }
  }
}
