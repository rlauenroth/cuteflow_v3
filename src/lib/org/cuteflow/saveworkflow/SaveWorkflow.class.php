<?php

class SaveWorkflow {

    public $context;
    public $serverUrl;

    public function  __construct() {

    }

    public function setContext(sfContext $context) {
        $this->context = $context;
    }

    public function setServerUrl($url) {
        $this->serverUrl = $url;
    }

    /**
     *
     * Create next station if a workflow is been saved
     *
     * @param array $slots, all SLots
     * @param int $userId, userid
     * @param int $versionId, version of workflow
     * @return true
     */
    public function getNextStation(array $slots, $userId, $versionId) {
        foreach($slots as $slot) {
            $wfProcessData = WorkflowProcessUserTable::instance()->getActiveProcessUserForWorkflowSlot($slot['workflowslot_id'],$userId)->toArray();
            $toChange = WorkflowProcessUserTable::instance()->getWaitingStation($slot['workflowslot_id'],$userId);
            foreach($toChange as $itemToChange) {
                $pdoObj = Doctrine::getTable('WorkflowProcessUser')->find($itemToChange->getId());
                $pdoObj->setDecissionstate('DONE');
                $pdoObj->setDateofdecission(time());
                $pdoObj->save();
            }
            $versionId = $versionId;
            $wfSlotId = $slot['workflowslot_id'];
            $wsUserId = $wfProcessData[0]['workflowslotuser_id'];
            $checkWorkflow = new CreateNextStation($versionId,$wfSlotId,$wsUserId, $this);
        }
        $workflowVersion = WorkflowTemplateTable::instance()->getWorkflowTemplateByVersionId($versionId);
        $workflowData = MailinglistVersionTable::instance()->getSingleVersionById($workflowVersion[0]->getMailinglisttemplateversionId())->toArray();


        if($workflowData[0]['sendtoallslotsatonce'] == 1) {
            $slots = WorkflowSlotTable::instance()->getSlotByVersionId($versionId);
            $isCompleted = true;
            foreach($slots as $slot) {
                $users = WorkflowSlotUserTable::instance()->getUserBySlotId($slot->getId());
                foreach($users as $user) {
                    $processUsers = WorkflowProcessUserTable::instance()->getProcessUserByWorkflowSlotUserId($user->getId());
                    foreach($processUsers as $singleUser) {
                        $userArray = $singleUser->toArray();
                        if($userArray['decissionstate'] == 'WAITING') {
                            $isCompleted = false;
                        }
                    }
                }
            }
            if($isCompleted == true) {
                WorkflowTemplateTable::instance()->setWorkflowFinished($workflowVersion[0]['id']);
                $checkWorkflow->checkEndAction();
            }
        }
        return true;
    }

    /**
     *
     * @param array $data, contains reason for deny
     * @param int $workflowid, workflow id
     * @param int $userId, user id
     * @param int $versionId, version id
     * @return <type>
     */
    public function denyWorkflow(array $data, $workflowid, $userId, $versionId) {
        WorkflowTemplateTable::instance()->stopWorkflow($workflowid, $userId);
        WorkflowVersionTable::instance()->setEndReason($versionId, $data['workfloweditAcceptWorkflow_reason']);
        $workflowToStop = WorkflowProcessUserTable::instance()->getWaitingStationToStopByUser($versionId);
        foreach($workflowToStop as $itemToChange) {
            $pdoObj = Doctrine::getTable('WorkflowProcessUser')->find($itemToChange->getId());
            $pdoObj->setDecissionstate('STOPPEDBYUSER');
            $pdoObj->setDateofdecission(time());
            $pdoObj->save();
        }
        return true;
    }

    /**
     * Check if the fields are correctly filled, only in IFRAME 
     * @param array $fields, field data
     * @return $failure
     */
    public function checkFields(array $fields) {
        $failure = array();
        $failure['isFalse'] = 0;
        $counter = 0;
        foreach($fields as $field) {
            if($field['type'] == 'TEXTFIELD' OR $field['type'] == 'NUMBER' OR $field['type'] == 'DATE') {
                if($field['value'] != '') {
                    if($field['regex'] != '') {
                        if (@!preg_match('/'.$field['regex'].'/', $field['value'])) {
                            $failure[$counter++] = $field['name'];
                            $failure['isFalse'] = 1;
                            $correctFields = false;
                        }
                    }
                }
            }
        }
        return $failure;

    }

}
?>
