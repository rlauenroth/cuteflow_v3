<?php
/**
 *
 * Class contains function to create a process and add processuser to the process
 *
 *
 */
class WorkflowCreation {


    public function  __construct() {

    }

    /**
     *
     * Create a new process entry in WorkflowProcess table.
     * This enty can contain several child elemnts, if a useragent is set for the entry
     *
     * @param int $workflow_template_id, id of the workflowtemplate
     * @param int $workflow_version_id, id of the active workflowversion
     * @param int $workflow_slot_id, id of the workflowslot
     * @return int $wfProcessId, id of the process, needed to add child elements
     */
    public function addProcess($workflow_template_id, $workflow_version_id, $workflow_slot_id) {
        $wfProcess = new WorkflowProcess();
        $wfProcess->setWorkflowTemplateId($workflow_template_id);
        $wfProcess->setWorkflowVersionId($workflow_version_id);
        $wfProcess->setWorkflowSlotId($workflow_slot_id);
        $wfProcess->save();
        $wfProcessId = $wfProcess->getId();
        return $wfProcessId;
    }


    /**
     * Function adds users to a process with decission WAITING
     *
     * workflow_slot_user_id and user_id can be different, if a useragent is set.
     * then workflow_slot_user_id is still the same, but user_id is different and
     * set to id of the useragent
     *
     *
     * @param int $workflow_slot_user_id, id of the slotuser
     * @param int $user_id, id of the user which receives the workflow
     * @param int $wfProcessId, foreignkey from WorkflowProcess
     */
    public function addProcessUser($workflow_slot_user_id, $user_id, $wfProcessId) {
        $wfProcessUser = new WorkflowProcessUser();
        $wfProcessUser->setWorkflowProcessId($wfProcessId);
        $wfProcessUser->setWorkflowSlotUserId($workflow_slot_user_id);
        $wfProcessUser->setUserId($user_id);
        $wfProcessUser->setInProgressSince(time());
        $wfProcessUser->setDecissionState('WAITING');
        $wfProcessUser->setResendet(0);
        $wfProcessUser->save();
    }









}
?>
