<?php
/**
 * Class adds the WorkflowProcess and WorkflowProcessUser to database
 */
class CreateProcessUser extends WorkflowCreation {


    public $slot;

   /**
    *
    * @param CreateSlot $slot, slot object that contains all slots
    */
    public function  __construct(CreateSlot $slot) {
        $this->slot = $slot;
        $settings = $this->slot->slotSettings;
        $workflowUsers = WorkflowSlotUserTable::instance()->getUserBySlotId($settings['workflow_slot_id']);
        if($settings['send_to_all_receivers'] == 1) {
            foreach($workflowUsers as $user) {
                $wfProcessId = $this->addProcess($this->slot->workflow_id,$this->slot->version_id,$settings['workflow_slot_id']);
                $user = $user->toArray();
                $this->addProcessUser($user['id'], $user['user_id'], $wfProcessId);
                $mailObj = new PrepareStationEmail($slot->version_id, $slot->workflow_id, $user['user_id'], $slot->workflowObj->context, $slot->workflowObj->serverUrl);
            }
        }
        else {
            $wfProcessId = $this->addProcess($this->slot->workflow_id,$this->slot->version_id,$settings['workflow_slot_id']);
            $user = $workflowUsers[0]->toArray();
            $this->addProcessUser($user['id'], $user['user_id'], $wfProcessId);
            $mailObj = new PrepareStationEmail($slot->version_id, $slot->workflow_id, $user['user_id'], $slot->workflowObj->context, $slot->workflowObj->serverUrl);
        }
        #$this->checkSendToAllReceiver($wfProcessId);
    }


    /**
     *  Function checks if the slot is sendet to all receivers at once
     *
     * @param int $wfProcessId, id of the WorkflowProcess entry
     */
    public function checkSendToAllReceiver($wfProcessId) {
        $settings = $this->slot->slotSettings;
        $workflowUsers = WorkflowSlotUserTable::instance()->getUserBySlotId($settings['workflow_slot_id']);
        if($settings['send_to_all_receivers'] == 1) {
            foreach($workflowUsers as $user) {
                $singleUser = $user->toArray();
                $this->addProcessUser($singleUser['id'], $singleUser['user_id'], $wfProcessId);
                $mailObj = new PrepareStationEmail($slot->version_id, $slot->workflow_id, $user['user_id'], $slot->workflowObj->context, $slot->workflowObj->serverUrl);
            }

        }
        else {
            $user = $workflowUsers[0]->toArray();
            $this->addProcessUser($user['id'], $user['user_id'], $wfProcessId);
            $mailObj = new PrepareStationEmail($slot->version_id, $slot->workflow_id, $user['user_id'], $slot->workflowObj->context, $slot->workflowObj->serverUrl);
        }
    }


}

?>