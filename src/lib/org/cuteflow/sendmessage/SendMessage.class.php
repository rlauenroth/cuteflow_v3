<?php
class SendMessage extends EmailSettings {


    public function  __construct() {
        
    }

    public function sendSystemMail(UserMailSettings $userData, $subject, $content, $contenttype) {
        $this->setSender($userData->userSettings['system_reply_address']);
        $this->setReceiver(array ($userData->userData['email'] => $userData->userData['firstname'] . ' ' . $userData->userData['lastname']));
        $this->setSubject($subject);
        $this->setContentType('text/' . $contenttype);
        $this->setBody($content);
        $this->sendEmail();
    }

}
?>