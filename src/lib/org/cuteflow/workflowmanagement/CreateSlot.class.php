<?php

/**
 * Function adds a new slot to WorkflowSlot
 */
class CreateSlot {


    public $slot;
    public $version_id;
    public $slotSettings;
    public $workflow_id;
    public $workflowObj;


    /**
     *
     * @param WorkflowSlot $slot, Object with slots
     * @param int $version_id, id of the current version
     * @param int $workflow_id, id of the workflowtemplate
     */
    public function  __construct(WorkflowSlot $slot, $version_id, $workflow_id, CreateWorkflow $createWf) {
        $this->workflowObj = $createWf;
        $this->slot = $slot;
        $this->version_id = $version_id;
        $this->workflow_id = $workflow_id;
        $this->setSlotId();
        $this->setWorkflowSlotId();
        $this->setSendToAll();
        new CreateProcessUser($this);
    }


    /**
     * set workflowid
     */
    public function setWorkflowSlotId() {
        $this->slotSettings['workflow_slot_id'] = $this->slot->getId();

    }
    /**
     * set slotid
     */
    public function setSlotId() {
        $this->slotSettings['slot_id'] = $this->slot->getSlotId();
    }

    /**
     * set send_to_all_receivers
     */
    public function setSendToAll() {
        $slotdata = $this->slot->getDocumentTemplateSlot()->toArray();
        $this->slotSettings['send_to_all_receivers'] = $slotdata[0]['send_to_all_receivers'];
    }












}


?>