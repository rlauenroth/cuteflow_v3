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
     * @param int $workflowtemplate_id, id of the workflowtemplate
     * @param int $workflowversion_id, id of the active workflowversion
     * @param int $workflowslot_id, id of the workflowslot
     * @return int $wfProcessId, id of the process, needed to add child elements
     */
    public function addProcess($workflowtemplate_id, $workflowversion_id, $workflowslot_id) {
        $wfProcess = new WorkflowProcess();
        $wfProcess->setWorkflowtemplateId($workflowtemplate_id);
        $wfProcess->setWorkflowversionId($workflowversion_id);
        $wfProcess->setWorkflowslotId($workflowslot_id);
        $wfProcess->save();
        $wfProcessId = $wfProcess->getId();
        return $wfProcessId;
    }


    /**
     * Function adds users to a process with decission WAITING
     *
     * workflowslotuser_id and user_id can be different, if a useragent is set.
     * then workflowslotuser_id is still the same, but user_id is different and
     * set to id of the useragent
     *
     *
     * @param int $workflowslotuser_id, id of the slotuser
     * @param int $user_id, id of the user which receives the workflow
     * @param int $wfProcessId, foreignkey from WorkflowProcess
     */
    public function addProcessUser($workflowslotuser_id, $user_id, $wfProcessId) {
        $wfProcessUser = new WorkflowProcessUser();
        $wfProcessUser->setWorkflowprocessId($wfProcessId);
        $wfProcessUser->setWorkflowslotuserId($workflowslotuser_id);
        $wfProcessUser->setUserId($user_id);
        $wfProcessUser->setInprogresssince(time());
        $wfProcessUser->setDecissionstate('WAITING');
        $wfProcessUser->setResendet(0);
        $wfProcessUser->save();
    }









}
?>
