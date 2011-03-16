<?php

/**
 * The Class check slots, checks if the workflow is alreasy finished, or
 * if a new slot must be created, and the users added
 */
class CheckSlot {


    private $nextStation;
    private $workflowSlotUser;
    private $decission;
 

    /**
     * @param CreateNextStation $nextStation, Object CreateNextStation
     */
    public function  __construct(CreateNextStation $nextStation) {
        $this->nextStation = $nextStation;
        
    }

    /**
     * Set all receivers for a workflowslot
     */
    public function setWorkflowSlotUser() {
        $this->workflowSlotUser = WorkflowSlotUserTable::instance()->getUserBySlotId($this->nextStation->workflowslot_id);#
    }


    /**
     * Function is only called when sendToAllReceivers is 1.
     * This function creates an array that contains all Decissions according to an WorkflowSlot and its WorkflowUsers
     */
    public function checkCurrentSlot() {
        $result = array();
        foreach($this->workflowSlotUser as $user) {
            $processUser = WorkflowProcessUserTable::instance()->getProcessUserByWorkflowSlotUserId($user->getId())->toArray();
            $this->decission[] = $this->checkProcessState($processUser);
        }
    }


    /**
     *
     * @param array $processUser, all processes form WorkflowProcessUser from a corresponding WorkflowSlotUser
     * @return bool $flag, 1 = if no state == WAITING, 0 = if != WAITING
     */
    public function checkProcessState(array $processUser) {
        $flag = 1;
        foreach($processUser as $user) {
            if($user['decissionstate'] == 'WAITING') {
                $flag =  0;
            }
        }
        return $flag;
    }


    /**
     * Check Slot Writing checks the array $this->decission, if a slot needs to be written.
     * A new slot is only written, if the workflow is not sendet to all slots at once and
     * if all decissionsstaets are != WAITING
     */
    public function checkSlotWriting() {
        $writeSlot = 1;
        foreach($this->decission as $item) {
            if($item === 0) {
                $writeSlot = 0;
            }
        }
        if($writeSlot == 1 AND $this->nextStation->sendToAllAtOnce == 0) {
            $this->checkForNewSlot($this->nextStation->workflowslot_id);
        }
        else {
            $this->nextStation->checkSendToAllAtOnce();
        }
    }


    /**
     *
     * This function tries to load the next WorkflowSlot.
     * First the complete SLotData is loaded and then theres a try to load the
     * next Slot. If no slot available, the Worklfow has reached the end
     * If a new slot is found addNewSlot method is called
     *
     *
     * @param int $currentWorkflowSlotId, is the id of the current WorkflowSlot
     */
    public function checkForNewSlot($currentWorkflowSlotId) {
        $currentSlot = WorkflowSlotTable::instance()->getSlotById($currentWorkflowSlotId)->toArray();
        $nextSlot = WorkflowSlotTable::instance()->getSlotByWorkflowversionAndPosition($currentSlot[0]['workflowversion_id'],$currentSlot[0]['position']+1);
        $slotArray = $nextSlot->toArray();
        if(empty($slotArray) == true AND $this->nextStation->sendToAllAtOnce != 1) { // workflow has finifshed
            WorkflowTemplateTable::instance()->setWorkflowFinished($this->nextStation->workflowtemplate_id);
            $this->nextStation->checkEndAction();
        }
        else {
            if($this->nextStation->sendToAllAtOnce == 0) {
                $this->addNewSlot($nextSlot);
            }
        }
    }




    /**
     *
     * Function checks if the next slot, needs to be sendet to all receivers at once,
     * or not. Then it loads the Users and adds them
     *
     * @param Doctrine_Collection $slot, WorkflowSlot Object that contains the next slot which is needed to be added.
     */
    public function addNewSlot(Doctrine_Collection $slot) {
        $mail = new SendSlotReachedEmail($this->nextStation->workflowslot_id, $slot[0]->getId(), $this->nextStation->workflowtemplate_id, $this->nextStation->version_id);
        $documenttemplateSlot = $slot[0]->getDocumenttemplateSlot()->toArray();
        $slotUser = WorkflowSlotUserTable::instance()->getUserBySlotId($slot[0]->getId())->toArray();
        if($documenttemplateSlot[0]['sendtoallreceivers'] == 1) {
            $processId = $this->nextStation->addProcess($this->nextStation->workflowtemplate_id, $this->nextStation->version_id, $slot[0]->getId());
            foreach($slotUser as $item) {
                $this->nextStation->addProcessUser($item['id'], $item['user_id'], $processId);
                $this->nextStation->checkSendToAllAtOnce();
            }
        }
        else {            
            $processId = $this->nextStation->addProcess($this->nextStation->workflowtemplate_id, $this->nextStation->version_id, $slot[0]->getId());
            $this->nextStation->addProcessUser($slotUser[0]['id'], $slotUser[0]['user_id'], $processId);
            $this->nextStation->checkSendToAllAtOnce();
        }
    }



}

?>
