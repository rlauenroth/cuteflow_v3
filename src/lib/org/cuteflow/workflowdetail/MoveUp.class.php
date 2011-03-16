<?php


class MoveUp extends WorkflowSetStation{


    public $station;

    public function  __construct(SetStation $station) {
        $this->station = $station;
        $this->setStationInactive($this->station->currentWorkflowSlotUser->getId());
        $this->calculateStation($this->station->currentWorkflowSlotUser->getWorkflowslotId(),$this->station->currentWorkflowSlotUser->getPosition()+1);
        $this->checkSendToAllReceiverAtOnce($this->station->currentSlotSendToAllReceiver, $this->station->currentWorkflowSlotUser, 'SKIPPED');
        $this->checkSendToAllReceiverAtOnce($this->station->newSlotSendToAllReceiver, $this->station->newWorkflowSlotUser, 'WAITING');
    }

    /**
     * Fill the users
     *
     * @param bool $sendToAllReceiverFlag
     * @param id $workflowslotUser
     * @param String $decission, skipped or waiting
     */
    public function checkSendToAllReceiverAtOnce($sendToAllReceiverFlag, $workflowslotUser, $decission) {
        if($sendToAllReceiverFlag == 1) {
            $station = WorkflowSlotUserTable::instance()->getUserBySlotId($workflowslotUser->getWorkflowslotId())->toArray();
            foreach($station as $item) {
                WorkflowProcessUserTable::instance()->deleteWorkflowProcessUserByWorkfloSlotUserId($item['id']);
            }
            WorkflowProcessTable::instance()->deleteWorkflowProcessByWorkflowSlotId($workflowslotUser->getWorkflowslotId());
            foreach($station as $item) {
                 $wfp = new WorkflowProcess();
                 $wfp->setWorkflowtemplateId($this->station->workflowtemplate_id);
                 $wfp->setWorkflowversionId($this->station->version_id);
                 $wfp->setWorkflowslotId($workflowslotUser->getWorkflowslotId());
                 $wfp->save();
                 $wfoId = $wfp->getId();

                 $wfpu = new WorkflowProcessUser();
                 $wfpu->setWorkflowprocessId($wfoId);
                 $wfpu->setWorkflowslotuserId($item['id']);
                 $wfpu->setUserId($item['user_id']);
                 $wfpu->setInprogresssince(time());
                 $wfpu->setDecissionstate($decission);
                 $wfpu->setResendet(0);
                 $wfpu->save();
                 if($decission == 'WAITING') {
                     $mail = new PrepareStationEmail($this->station->version_id, $this->station->workflowtemplate_id, $item['user_id'], $this->station->context, $this->station->serverUrl);
                 }
            }
        }
        
    }
    /**
     * Set current station inactive
     *
     * @param int $workflowslotuser_id, Workflowslot userid
     */
    public function setStationInactive($workflowslotuser_id) {
        WorkflowProcessUserTable::instance()->skipAllStation($workflowslotuser_id);
    }


    /**
     * Calculate the next stations and set them to inactive
     *
     * @param int $workflowslot_id, id of the slot
     * @param int $position, position
     * @return <type>
     */
    public function calculateStation($workflowslot_id, $position) {
        $nextUser = $this->getNextUser($workflowslot_id, $position);
         if(!empty($nextUser)) {
             if($nextUser[0]['id'] != $this->station->newWorkflowSlotUser_id) {
                 $wfp = new WorkflowProcess();
                 $wfp->setWorkflowtemplateId($this->station->workflowtemplate_id);
                 $wfp->setWorkflowversionId($this->station->version_id);
                 $wfp->setWorkflowslotId($nextUser[0]['workflowslot_id']);
                 $wfp->save();
                 $wfoId = $wfp->getId();

                 $wfpu = new WorkflowProcessUser();
                 $wfpu->setWorkflowprocessId($wfoId);
                 $wfpu->setWorkflowslotuserId($nextUser[0]['id']);
                 $wfpu->setUserId($nextUser[0]['user_id']);
                 $wfpu->setInprogresssince(time());
                 $wfpu->setDecissionstate('SKIPPED');
                 $wfpu->setResendet(0);
                 $wfpu->save();
                 $this->calculateStation($nextUser[0]['workflowslot_id'], $nextUser[0]['position']+1);
             }
             else {
                 $wfp = new WorkflowProcess();
                 $wfp->setWorkflowtemplateId($this->station->workflowtemplate_id);
                 $wfp->setWorkflowversionId($this->station->version_id);
                 $wfp->setWorkflowslotId($nextUser[0]['workflowslot_id']);
                 $wfp->save();
                 $wfoId = $wfp->getId();

                 $wfpu = new WorkflowProcessUser();
                 $wfpu->setWorkflowprocessId($wfoId);
                 $wfpu->setWorkflowslotuserId($nextUser[0]['id']);
                 $wfpu->setUserId($nextUser[0]['user_id']);
                 $wfpu->setInprogresssince(time());
                 $wfpu->setDecissionstate('WAITING');
                 $wfpu->setResendet(0);
                 $wfpu->save();
                 $mail = new PrepareStationEmail($this->station->version_id, $this->station->workflowtemplate_id, $nextUser[0]['user_id'], $this->station->context, $this->station->serverUrl);
                 return true;
             }
         }
         else {
            $this->calculateSlot($workflowslot_id);
         }
    }
















}
?>