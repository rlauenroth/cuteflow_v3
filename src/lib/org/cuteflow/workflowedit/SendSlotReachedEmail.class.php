<?php
class SendSlotReachedEmail extends EmailSettings {

    public $currentSlot;
    public $nextSlot;
    public $workflowTemplateSettings;
    public $userSettings;
    public $workflowVersionId;
    /**
     *
     * @param int $currentWorklfowSlotId, workflowslotid of the current slot
     * @param int $nextSlotId , SlotId of the next slot
     */
    public function  __construct($currentWorklfowSlotId, $nextWorkflowSlotId, $workflowtemplateId, $workflowversionId) { 
        $this->setWorkflowTemplateSettings($workflowtemplateId);
        if($this->checkState() == 1) {
            $this->workflowVersionId = $workflowversionId;
            $this->setCurrentSlot($currentWorklfowSlotId);
            $this->setNextSlot($nextWorkflowSlotId);
            $this->setUserSettings();
            $this->sendSlotReachedMail();
        }
    }



    public function checkState() {
        $data = getEndAction($this->workflowTemplateSettings['end_action']);
        if($data[1] == 1) {
            return 1;
        }
        else {
            return 0;
        }
    }

    public function setUserSettings() {
        $this->userSettings = new UserMailSettings($this->workflowTemplateSettings['sender_id']);
    }


    public function setCurrentSlot($currentWorkflowSlotId) {
        $slotData = DocumentTemplateSlotTable::instance()->getSlotByWorkflowSlotId($currentWorkflowSlotId)->toArray();
        $this->currentSlot = $slotData[0];
    }


    public function setNextSlot($nextWorkflowSlotId) {
        $slotData = DocumentTemplateSlotTable::instance()->getSlotByWorkflowSlotId($nextWorkflowSlotId)->toArray();
        $this->nextSlot = $slotData[0];
    }

    public function setWorkflowTemplateSettings($workflowtemplateId) {
        $data = WorkflowTemplateTable::instance()->getWorkflowTemplateById($workflowtemplateId)->toArray();
        $this->workflowTemplateSettings = $data[0];
    }

    public function sendSlotReachedMail() {
        $sf_i18n = sfContext::getInstance()->getI18N();
        $sf_i18n->setCulture($this->userSettings->userSettings['language']);
        $content['workflow'] = sfContext::getInstance()->getI18N()->__('Workflow' ,null,'slotreachedemail') . ' ' . $this->workflowTemplateSettings['name'];
        $content['currentslot'][0] = sfContext::getInstance()->getI18N()->__('The Slot' ,null,'slotreachedemail');
        $content['currentslot'][1] = $this->currentSlot['name'];
        $content['currentslot'][2] = sfContext::getInstance()->getI18N()->__('has been completed' ,null,'slotreachedemail');

        $content['nextSlot'][0] = sfContext::getInstance()->getI18N()->__('The new Slot' ,null,'slotreachedemail');
        $content['nextSlot'][1] = $this->nextSlot['name'];
        $content['nextSlot'][2] = sfContext::getInstance()->getI18N()->__('has been reached' ,null,'slotreachedemail');
        $subject = sfContext::getInstance()->getI18N()->__('CuteFlow: slot' ,null,'slotreachedemail') . ' ' . $this->nextSlot['name'] . ' ' . sfContext::getInstance()->getI18N()->__('reached' ,null,'slotreachedemail');
        $linkTo = sfContext::getInstance()->getI18N()->__('Direct link to workflow' ,null,'slotreachedemail');
        $this->setSender($this->userSettings->userSettings['system_reply_address']);
        $this->setReceiver(array ($this->userSettings->userData['email'] => $this->userSettings->userData['firstname'] . ' ' . $this->userSettings->userData['lastname']));
        $this->setSubject($subject);
        $this->setContentType('text/' . $this->userSettings->userSettings['email_format']);
        $bodyData = array('text' => $content,
                          'userid' => $this->userSettings->userData['user_id'],
                          'workflowverion' => $this->workflowVersionId,
                          'workflow' => $this->workflowTemplateSettings['id'],
                          'linkto'  => $linkTo
                  );
        $this->setBody(get_partial('workflowdetail/' . $this->userSettings->userSettings['email_format'] . 'SendSlotReached', $bodyData));
        $this->sendEmail();
    }





}
?>
