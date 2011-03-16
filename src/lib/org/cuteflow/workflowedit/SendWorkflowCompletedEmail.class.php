<?php
class SendWorkflowCompleted extends EmailSettings {

    public $userSettings;
    public $workflowtemplate;
    public $version;

    public function __construct(array $workflowtemplate, $workflowversionid) {
        sfLoader::loadHelpers('Partial');
        $this->workflowtemplate = $workflowtemplate;
        $this->version = $workflowversionid;
        $this->setUserSettings($workflowtemplate['sender_id']);
        $this->sendWorkflowCompletedEmail();

    }



    public function setUserSettings($sender_id) {
        $this->userSettings = new UserMailSettings($sender_id);
    }

    public function sendWorkflowCompletedEmail() {
        $sf_i18n = sfContext::getInstance()->getI18N();
        $sf_i18n->setCulture($this->userSettings->userSettings['language']);

        $content['workflow'][0] = sfContext::getInstance()->getI18N()->__('Your Workflow' ,null,'workflowcompletedemail');
        $content['workflow'][1] = $this->workflowtemplate['name'];
        $content['workflow'][2] = sfContext::getInstance()->getI18N()->__('has been completed' ,null,'workflowcompletedemail');
        $linkTo = sfContext::getInstance()->getI18N()->__('Direct link to workflow' ,null,'workflowcompletedemail');
        $subject = sfContext::getInstance()->getI18N()->__('CuteFlow: Workflow' ,null,'workflowcompletedemail') . ' ' . $this->workflowtemplate['name'] . ' ' . sfContext::getInstance()->getI18N()->__('has been completed' ,null,'workflowcompletedemail');

        
        $this->setSender($this->userSettings->userSettings['systemreplyaddress']);
        $this->setReceiver(array ($this->userSettings->userData['email'] => $this->userSettings->userData['firstname'] . ' ' . $this->userSettings->userData['lastname']));
        $this->setSubject($subject);
        $this->setContentType('text/' . $this->userSettings->userSettings['emailformat']);
        $bodyData = array('text' => $content,
                          'userid' => $this->userSettings->userData['user_id'],
                          'workflowverion' => $this->version,
                          'workflow' => $this->workflowtemplate['id'],
                          'linkto'  => $linkTo
                  );
        $this->setBody(get_partial('workflowedit/' . $this->userSettings->userSettings['emailformat'] . 'WorkflowCompleted', $bodyData));
        $this->sendEmail();
    }


}
?>
