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
class calculateUserAgentTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'cuteflow'),
      new sfCommandOption('setenvironment', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment in large', ''), // for dev, use cuteflow_dev.php
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', ''),
      new sfCommandOption('host', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'http://cuteflow'), // http://cuteflow is default
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'calculateUserAgent';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [calculateUserAgent|INFO] task does things.
Call it with:

  [php symfony calculateUserAgent|INFO]
EOF;
  }

    protected function execute($arguments = array(), $options = array()) {
        // initialize the database connection
        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();
        $context = sfContext::createInstance($this->configuration);
        $context->getConfiguration()->loadHelpers('Partial', 'I18N', 'Url', 'Date', 'CalculateDate', 'ColorBuilder', 'Icon', 'EndAction');
        $serverUrl = $options['setenvironment'] == '' ? $serverUrl = $options['host'] : $serverUrl = $options['host'] . '/' . $options['setenvironment'];

        $system = SystemConfigurationTable::getInstance()->getSystemConfiguration()->toArray();
        if($system[0]['individual_cronjob'] == 1) {
            $systemConifg = new CheckSubstituteRun($context);
            if($systemConifg->checkRun($system[0]['cronjob_days'],$system[0]['cronjob_from'],$system[0]['cronjob_to']) == true) {
                $process = WorkflowProcessUserTable::instance()->getWaitingProcess(); // load all waiting processes
                $sub = new CheckSubstitute($process, $context, $serverUrl, $system[0]['set_user_agent_type']);
            }
        }
        else {
            $process = WorkflowProcessUserTable::instance()->getWaitingProcess(); // load all waiting processes
            $sub = new CheckSubstitute($process, $context, $serverUrl, $system[0]['set_user_agent_type']);
        }
    }
}
