<?php


class EmailSettings {



    public $sender;
    public $receiver;
    public $subject;
    public $body;
    public $contentType;
    public $attachments;
    public $emailConfig;
    public $transport;

    public function __construct() {

    }


    public function setMailer() {
        switch($this->emailConfig['active_type']) {
            case 'SMTP':
                $this->transport = Swift_SmtpTransport::newInstance()
                                   ->setHost($this->emailConfig['smtp_host'])
                                   ->setPort($this->emailConfig['smtp_port'])
                                   ->setEncryption($this->emailConfig['smtpencryption'])
                                   ->setUsername($this->emailConfig['smtp_username'])
                                   ->setPassword($this->emailConfig['smtp_password']);
                break;
            case 'MAIL':
                $this->transport = Swift_MailTransport::newInstance();
                break;
            case 'SENDMAIL';
                $this->transport = Swift_SendmailTransport::newInstance($this->emailConfig['send_mailpath']);
                break;
        }
    }
    public function getEmailConfiguration() {
        $config = EmailConfigurationTable::instance()->getEmailConfiguration()->toArray();
        return $config[0];
    }

    public function setSender($sender) {
        $this->sender = $sender;
    }

    public function setReceiver($receiver) {
        $this->receiver = $receiver;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function setContentType($type) {
        $this->contentType = $type;
    }

    public function setBody($body) {
        $this->body = $body;
    }


    public function setAttachments($items) {
        $a = 0;
        foreach($items as $attachment) {
            $this->attachments[$a]['filepath'] = $attachment['filepath'];
            $this->attachments[$a++]['filename'] = $attachment['filename'];
        }
    }


    public function sendEmail() {
        $this->emailConfig = $this->getEmailConfiguration();
        $this->setMailer();
        $mailerObject = Swift_Mailer::newInstance($this->transport);
        #$mailerObject = sfContext::getInstance()->getMailer();
        $message = Swift_Message::newInstance()
            ->setFrom($this->sender)
            ->setTo($this->receiver)
            ->setSubject($this->subject)
            ->setContentType($this->contentType)
            ->setBody($this->body);
        if(isset($this->attachments)) {
            foreach($this->attachments as $file) {
                $fileObj = new File();
                $filecontent = $fileObj->getFileContent($file['filepath']);
                $message->attach(Swift_Attachment::newInstance($filecontent, $file['filename']));
            }
        }
        try {
            if($this->emailConfig['allow_email_transport'] == 1) {
                $mailerObject->send($message);
            }
        }
        catch (Exception $e) {
            
        }
        
    }

}
?>