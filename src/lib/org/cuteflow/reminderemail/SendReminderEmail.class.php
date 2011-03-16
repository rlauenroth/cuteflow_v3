<?php

class SendReminderEmail extends EmailSettings {

    public function  __construct(UserMailSettings $userSettings, sfContext $controller, array $openWorkflows, $serverUrl) {
        $sf_i18n = $controller->getI18N();
        $sf_i18n->setCulture($userSettings->userSettings['language']);

        $content['text'] = $controller->getI18N()->__('You need to complete the following workflows' ,null,'sendreminderemail');
        $this->setSender($userSettings->userSettings['systemreplyaddress']);
        $this->setReceiver(array ($userSettings->userData['email'] => $userSettings->userData['firstname'] . ' ' . $userSettings->userData['lastname']));
        $subject = $controller->getI18N()->__('CuteFlow: open workflows' ,null,'sendreminderemail');
        $worfklowname = $controller->getI18N()->__('Workflowname' ,null,'sendreminderemail');
        $linkTo = $controller->getI18N()->__('Direct link to workflow' ,null,'sendreminderemail');
        $this->setSubject($subject);
        $this->setContentType('text/' . $userSettings->userSettings['emailformat']);
        $bodyData = array('text' => $content['text'], 
                          'workflow' => $openWorkflows['workflows'],
                          'workflowname' => $worfklowname,
                          'userid' => $userSettings->userData['user_id'],
                          'serverPath' => $serverUrl,
                          'linkto' => $linkTo
                          );
        
        $this->setBody(get_partial('sendreminderemail/' . $userSettings->userSettings['emailformat'], $bodyData));
        $this->sendEmail();
    }
}
?>
