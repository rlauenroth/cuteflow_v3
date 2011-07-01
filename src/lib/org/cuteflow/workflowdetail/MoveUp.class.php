<?php

class MoveUp extends WorkflowSetStation {

    public $station;

    public function __construct(SetStation $station) {
        $this->station = $station;
        $this->setStationInactive($this->station->currentWorkflowSlotUser->getId());
        $this->calculateStation($this->station->currentWorkflowSlotUser->getWorkflowSlotId(), $this->station->currentWorkflowSlotUser->getPosition() + 1);
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
        if ($sendToAllReceiverFlag == 1) {
            $station = WorkflowSlotUserTable::instance()->getUserBySlotId($workflowslotUser->getWorkflowSlotId())->toArray();
            foreach ($station as $item) {
                WorkflowProcessUserTable::instance()->deleteWorkflowProcessUserByWorkfloSlotUserId($item['id']);
            }
            WorkflowProcessTable::instance()->deleteWorkflowProcessByWorkflowSlotId($workflowslotUser->getWorkflowSlotId());
            foreach ($station as $item) {
                $wfp = new WorkflowProcess();
                $wfp->setWorkflowTemplateId($this->station->workflow_template_id);
                $wfp->setWorkflowVersionId($this->station->version_id);
                $wfp->setWorkflowSlotId($workflowslotUser->getWorkflowSlotId());
                $wfp->save();
                $wfoId = $wfp->getId();

                $wfpu = new WorkflowProcessUser();
                $wfpu->setWorkflowProcessId($wfoId);
                $wfpu->setWorkflowSlotUserId($item['id']);
                $wfpu->setUserId($item['user_id']);
                $wfpu->setInProgressSince(time());
                $wfpu->setDecissionState($decission);
                $wfpu->setResendet(0);
                $wfpu->save();
                if ($decission == 'WAITING') {
                    $mail = new PrepareStationEmail($this->station->version_id, $this->station->workflow_template_id, $item['user_id'], $this->station->context, $this->station->serverUrl);
                }
            }
        }
    }

    /**
     * Set current station inactive
     *
     * @param int $workflow_slot_user_id, Workflowslot userid
     */
    public function setStationInactive($workflow_slot_user_id) {
        WorkflowProcessUserTable::instance()->skipAllStation($workflow_slot_user_id);
    }

    /**
     * Calculate the next stations and set them to inactive
     *
     * @param int $workflow_slot_id, id of the slot
     * @param int $position, position
     * @return <type>
     */
    public function calculateStation($workflow_slot_id, $position) {
        $nextUser = $this->getNextUser(workflow_slot_id, $position);
        if (!empty($nextUser)) {
            if ($nextUser[0]['id'] != $this->station->newWorkflowSlotUser_id) {
                $wfp = new WorkflowProcess();
                $wfp->setWorkflowTemplateId($this->station->workflow_template_id);
                $wfp->setWorkflowVersionId($this->station->version_id);
                $wfp->setWorkflowSlotId($nextUser[0]['workflow_slot_id']);
                $wfp->save();
                $wfoId = $wfp->getId();

                $wfpu = new WorkflowProcessUser();
                $wfpu->setWorkflowProcessId($wfoId);
                $wfpu->setWorkflowSlotUserId($nextUser[0]['id']);
                $wfpu->setUserId($nextUser[0]['user_id']);
                $wfpu->setInProgressSince(time());
                $wfpu->setDecissionState('SKIPPED');
                $wfpu->setResendet(0);
                $wfpu->save();
                $this->calculateStation($nextUser[0]['workflow_slot_id'], $nextUser[0]['position'] + 1);
            } else {
                $wfp = new WorkflowProcess();
                $wfp->setWorkflowTemplateId($this->station->workflow_template_id);
                $wfp->setWorkflowVersionId($this->station->version_id);
                $wfp->setWorkflowSlotId($nextUser[0]['workflow_slot_id']);
                $wfp->save();
                $wfoId = $wfp->getId();

                $wfpu = new WorkflowProcessUser();
                $wfpu->setWorkflowProcessId($wfoId);
                $wfpu->setWorkflowSlotUserId($nextUser[0]['id']);
                $wfpu->setUserId($nextUser[0]['user_id']);
                $wfpu->setInProgressSince(time());
                $wfpu->setDecissionState('WAITING');
                $wfpu->setResendet(0);
                $wfpu->save();
                $mail = new PrepareStationEmail($this->station->version_id, $this->station->workflow_template_id, $nextUser[0]['user_id'], $this->station->context, $this->station->serverUrl);
                return true;
            }
            
        } else {
            $this->calculateSlot($workflow_slot_id);
        }
    }
    
}
    