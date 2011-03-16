<?php
class PrepareStationEmail {

    public $versionId;
    public $workflowDetailsObj;
    public $workflowDetailsData;
    public $workflowSettings;
    public $attachments;
    public $workflowEditObj;
    public $userSettings;
    public $slots;
    public $templateId;
    public $context;
    public $serverUrl;


    /**
     *
     * Load all Slots and Fields for a workflow and then send the email
     *
     * @param int $versionId, id of the current workflowversion
     * @param int $templateId, id of the current workflowtemplate
     * @param int $userId, userid
     * @param sfContext $context, context
     * @param String $serverUrl, server url
     */
    public function __construct($versionId, $templateId, $userId, sfContext $context, $serverUrl) {
        if($this->checkSendingRight() == true) {
            $this->serverUrl = $serverUrl;
            $this->userId = $userId;
            $this->context = $context;
            $this->userSettings = new UserMailSettings($userId);
            $this->versionId = $versionId;
            $this->templateId = $templateId;
            $this->workflowSettings = WorkflowVersionTable::instance()->getWorkflowVersionById($versionId);
            $this->workflowDetailsObj = new WorkflowDetail(false);
            $this->workflowDetailsObj->setServerUrl($serverUrl);
            $this->workflowDetailsObj->setCulture($this->userSettings->userSettings['language']);
            $this->workflowDetailsObj->setContext($context);
            $this->setWorkflowDetailData();
            $this->setAttachments();

            $this->workflowEditObj = new WorkflowEdit(false);
            $this->workflowEditObj->setServerUrl($serverUrl);
            $this->workflowEditObj->setContext($context);
            $this->workflowEditObj->setCulture($this->userSettings->userSettings['language']);
            $this->workflowEditObj->setUserId($this->userId);
            $this->slots = $this->workflowEditObj->buildSlots($this->workflowSettings , $this->versionId);
            $this->makeDecission();
        }
    }

    /**
     * Check if an email can be send
     *
     * @return boolean
     */
    public function checkSendingRight() {
        $wfSettings = SystemConfigurationTable::instance()->getSystemConfiguration()->toArray();
        if($wfSettings[0]['sendreceivermail'] == 1) {
            return true;
        }
        else {
            return false;
        }
    }


    public function setWorkflowDetailData() {
        $this->workflowDetailsData = $this->workflowDetailsObj->buildHeadLine($this->workflowSettings);
    }


    public function setAttachments() {
        $this->attachments = $this->workflowDetailsObj->buildAttachments($this->workflowSettings, $this->versionId);
    }


    public function makeDecission() {
        $userSettings = $this->userSettings->userSettings;
        if($userSettings['emailformat'] == 'plain') {
            $sendMail = new PlainHtmlWithValues($this);
        }
        else {
            if($userSettings['emailtype'] == 'VALUES') {
                $sendMail = new PlainHtmlWithValues($this);
            }
            else {
                $sendMail = new HtmlWithIFrame($this);
            }
        }
    }

    
    
}
?>
