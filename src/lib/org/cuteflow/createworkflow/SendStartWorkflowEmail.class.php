<?php
class SendStartWorkflowEmail extends EmailSettings {

    /**
     * Send an email, when workflow is started in the future
     *
     * @param UserMailSettings $userSettings, Object that contains useragent settings
     * @param sfContext $controller
     * @param array $workflowVersion, workflowversion details
     * @param array $workflowTemplate, workfowtemplate detials
     * @param String $serverUrl , url of the server,
     */
    public function  __construct(UserMailSettings $userSettings, sfContext $controller, array $workflowVersion, array $workflowTemplate, $serverUrl) {
        $sf_i18n = $controller->getI18N();
        $sf_i18n->setCulture($userSettings->userSettings['language']);

        $content['text'] = $controller->getI18N()->__('Your workflow' ,null,'createworkflow') . ' '. $workflowTemplate[0]['name'] . ' ' . $controller->getI18N()->__('has been started' ,null,'createworkflow');
        
        $this->setSender($userSettings->userSettings['systemreplyaddress']);
        $this->setReceiver(array ($userSettings->userData['email'] => $userSettings->userData['firstname'] . ' ' . $userSettings->userData['lastname']));

        $subject = $controller->getI18N()->__('CuteFlow: workflow started' ,null,'createworkflow');
        $this->setSubject($subject);
        $linkTo = $controller->getI18N()->__('Direct link to workflow' ,null,'createworkflow');
        $this->setContentType('text/' . $userSettings->userSettings['emailformat']);
        $bodyData = array('text' => $content['text'],
                          'userid' => $userSettings->userData['user_id'],
                          'workflow' => $workflowVersion,
                          'serverPath' => $serverUrl,
                          'linkto'  => $linkTo
                          );
        $this->setBody(get_partial('createworkflow/' . $userSettings->userSettings['emailformat'] . 'StartWorkflowInFuture', $bodyData));
        $this->sendEmail();
    }


    
}
?>
