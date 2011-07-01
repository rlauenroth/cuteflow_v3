<?php



class MoveDown extends WorkflowSetStation {


    public $station;

    public function  __construct(SetStation $station) {
        $this->station = $station;
        $this->setNewStationActive($this->station->newWorkflowSlotUser,$this->station->version_id, $this->station->workflow_template_id);
        $this->calculateStation($this->station->newWorkflowSlotUser->getWorkflowSlotId(),$this->station->newWorkflowSlotUser->getPosition()+1);
        $this->checkCurrentSlot();
        $this->checkNewSlot();
    }

    /**
     * check if the new slot is send to all at once, if yes at processes
     */
    public function checkNewSlot() {
        if($this->station->newSlotSendToAllReceiver == 1) {
            $station = WorkflowSlotUserTable::instance()->getUserBySlotId($this->station->newWorkflowSlotUser->getWorkflowSlotId())->toArray();
            foreach($station as $item) {
                WorkflowProcessUserTable::instance()->deleteWorkflowProcessUserByWorkfloSlotUserId($item['id']);
            }
            WorkflowProcessTable::instance()->deleteWorkflowProcessByWorkflowSlotId($this->station->newWorkflowSlotUser->getWorkflowSlotId());
            foreach($station as $item) {
                 $wfp = new WorkflowProcess();
                 $wfp->setWorkflowTemplateId($this->station->workflow_template_id);
                 $wfp->setWorkflowVersionId($this->station->version_id);
                 $wfp->setWorkflowSlotId($this->station->newWorkflowSlotUser->getWorkflowSlotId());
                 $wfp->save();
                 $wfoId = $wfp->getId();
                 $wfpu = new WorkflowProcessUser();
                 $wfpu->setWorkflowProcessId($wfoId);
                 $wfpu->setWorkflowSlotUserId($item['id']);
                 $wfpu->setUserId($item['user_id']);
                 $wfpu->setInProgressSince(time());
                 $wfpu->setDecissionState('WAITING');
                 $wfpu->setResendet(0);
                 $wfpu->save();
                 $mail = new PrepareStationEmail($this->station->version_id, $this->station->workflow_template_id, $item['user_id'], $this->station->context, $this->station->serverUrl);
            }
        }
    }
    
    /**
     * If slot is sent to all at once, remove all users
     */
    public function checkCurrentSlot() {
        if($this->station->currentSlotSendToAllReceiver == 1) {
            $station = WorkflowSlotUserTable::instance()->getUserBySlotId($this->station->currentWorkflowSlotUser->getWorkflowSlotId())->toArray();
            foreach($station as $item) {
                WorkflowProcessUserTable::instance()->deleteWorkflowProcessUserByWorkfloSlotUserId($item['id']);
            }
            WorkflowProcessTable::instance()->deleteWorkflowProcessByWorkflowSlotId($this->station->currentWorkflowSlotUser->getWorkflowSlotId());
        }
        
    }


    /**
     * Write the new Station and set active write email
     *
     * @param WorkflowSlotUser $user
     * @param int $version_id, workflowversion id
     * @param int $workflow_template_id , workfowtemplate id
     */
    public function setNewStationActive (WorkflowSlotUser $user, $version_id, $workflow_template_id) {
        $currentWorkflowProcessUser = WorkflowProcessUserTable::instance()->getProcessUserByWorkflowSlotUserId($user->getId());
        WorkflowProcessUserTable::instance()->deleteWorkflowProcessUserByWorkfloSlotUserId($user->getId());
        $workflowPU = new WorkflowProcessUser();
        $workflowPU->setWorkflowProcessId($currentWorkflowProcessUser[0]->getWorkflowProcessId());
        $workflowPU->setWorkflowSlotUserId($user->getId());
        $workflowPU->setUserId($user->getUserId());
        $workflowPU->setInProgressSince(time());
        $workflowPU->setDecissionState('WAITING');
        $workflowPU->setResendet(0);
        $workflowPU->save();
        $mail = new PrepareStationEmail($this->station->version_id, $this->station->workflow_template_id, $user->getUserId(), $this->station->context, $this->station->serverUrl);

    }

    /**
     * Now the slots / stations between the old id and the new id must be filled.
     * This function calculates the slots and users and fills it
     *
     * @param int $workflow_slot_id, id of the slot
     * @param int $position, SLot position
     */
    public function calculateStation($workflow_slot_id, $position) {
        $nextUser = $this->getNextUser($workflow_slot_id, $position);
        if(!empty($nextUser)) { // user has been found
            $currentWorkflowProcessUser = WorkflowProcessUserTable::instance()->getProcessUserByWorkflowSlotUserId($nextUser[0]['id'])->toArray();
            if(!empty($currentWorkflowProcessUser)) { // user has a process, then remove it
                WorkflowProcessUserTable::instance()->deleteWorkflowProcessUserByWorkfloSlotUserId($currentWorkflowProcessUser[0]['workflow_slot_user_id']);
                WorkflowProcessTable::instance()->deleteWorkflowProcessById($currentWorkflowProcessUser[0]['workflow_process_id']);
                $this->calculateStation($nextUser[0]['workflow_slot_id'], $nextUser[0]['position']+1);
            }
            else {
                $this->calculateStation($nextUser[0]['workflow_slot_id'], $nextUser[0]['position']+1); // user has no process running, the search for next user
            }
        }
        else {
            $this->calculateSlot($workflow_slot_id);
        }
    }

    









}
?>