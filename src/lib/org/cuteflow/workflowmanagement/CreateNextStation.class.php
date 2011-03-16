<?php
/**
 *
 * Class CreateNextStation extends WorkflowCration to gain functions to add a new WorkflowProcess und Users.
 * This class calculates, the next user and the next slot for an workflow
 *
 */
class CreateNextStation extends WorkflowCreation{


    public $version_id;
    public $workflowslot_id;
    public $workflowslotuser_id;
    public $userPosition;
    public $sendToAllReceivers;
    public $sendToAllAtOnce;
    public $workflowtemplate_id;
    public $workflow;
    public $workflowversion;
    public $saveWorkflowObject;

    /**
     *
     * @param int $version_id, current version
     * @param int $workflowslot_id, current workflowslot id
     * @param int $workflowslotuser_id, current workflowslotuser id
     */
    public function __construct($version_id, $workflowslot_id, $workflowslotuser_id, SaveWorkflow $saveWfObj) {
        $this->saveWorkflowObject = $saveWfObj;
        $this->version_id = $version_id;
        $this->workflowslot_id = $workflowslot_id;
        $this->workflowslotuser_id = $workflowslotuser_id;
        $this->setWorkflowUserPosition();
        $this->setSendToAllReceivers();
        $this->setSendToAllAtOnce();
        $this->makeDecission();
    }

    /**
     * Function sets the flag SendToAllReceivers of the current workflowslot
     */
    public function setSendToAllReceivers() {
        $slot = WorkflowSlotTable::instance()->getSlotById($this->workflowslot_id);
        $documentSlot = $slot[0]->getDocumenttemplateSlot()->toArray();
        $this->sendToAllReceivers = $documentSlot[0]['sendtoallreceivers'];
    }
    
    /**
     * Function sets SendToAllAtOnce Flag of the Worklfow and also sets the WorkflowTemplateId
     */
    public function setSendToAllAtOnce() {
        $workflow = WorkflowVersionTable::instance()->getWorkflowVersionById($this->version_id);
        $workflowVersion = WorkflowTemplateTable::instance()->getWorkflowTemplateByVersionId($this->version_id);
        $this->workflow = $workflow->toArray();
        $this->workflowversion = $workflowVersion->toArray();
        $template = MailinglistVersionTable::instance()->getSingleVersionById($workflowVersion[0]->getMailinglisttemplateversionId())->toArray();
        $this->sendToAllAtOnce = $template[0]['sendtoallslotsatonce'];
        $this->workflowtemplate_id = $workflow[0]->getWorkflowtemplateId();
    }


    /**
     * Set the current position of the current user from WorkflowUserTable.
     * This is needed to caclulate the next user in the workflow
     */
    public function setWorkflowUserPosition() {
        $pos = WorkflowSlotUserTable::instance()->getUserById($this->workflowslotuser_id);
        $this->userPosition = $pos[0]->getPosition();
    }


    /**
     * Function makes decission out of an slots flag sendToAllReceivers.
     * If the slot is sendet to all Receivers at once, a check is done, if all users have entered already a value
     * and then a new station in a new slot will be created.
     *
     * If sendToAllReceivers is 0, a the next user with userPosition+1 will be loaded.
     * If loading user succeeded, writing user to WorkflowProcessTable will be done.
     * If getting user does not succeed, there's a need to check if a new slot needs to be written or
     * if worklfow has finished
     *
     */
    public function makeDecission() {
        if($this->sendToAllReceivers == 1) { // send to all SlotReceivers here
            $erg = new CheckSlot($this);
            $erg->setWorkflowSlotUser();
            $erg->checkCurrentSlot();
            $erg->checkSlotWriting();
        }
        else {
            $nextUser = WorkflowSlotUserTable::instance()->getUserBySlotIdAndPosition($this->workflowslot_id, $this->userPosition+1)->toArray();
            if(empty($nextUser) == true) {
                $createSlot = new CheckSlot($this);
                $createSlot->checkForNewSlot($this->workflowslot_id);
                $this->checkSendToAllAtOnce();
            }
            else {
                $processId = $this->addProcess($this->workflowtemplate_id, $this->version_id, $this->workflowslot_id);
                $this->addProcessUser($nextUser[0]['id'], $nextUser[0]['user_id'], $processId);
                $mail = new PrepareStationEmail($this->version_id,$this->workflowtemplate_id, $nextUser[0]['user_id'], $this->saveWorkflowObject->context,$this->saveWorkflowObject->serverUrl );

                $this->checkSendToAllAtOnce();
            }
        }
    }


    /**
     * Function is needed, when a worklow is sendet to all slots at once.
     * This function checks if each Entry from WorkflowProcessUser is != WAITING
     *
     * If no user needs to fill out the workflow, the workflow is completed and flag will be set
     */
    public function checkSendToAllAtOnce() {
        if($this->sendToAllAtOnce == 1) {
            $slots = WorkflowSlotTable::instance()->getSlotByVersionId($this->version_id);
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
                WorkflowTemplateTable::instance()->setWorkflowFinished($this->workflowtemplate_id);
                $this->checkEndAction();
            }
        }
    }


    public function checkEndAction() {
        sfLoader::loadHelpers('EndAction');
        $data = getEndAction($this->workflowversion[0]['endaction']);
        if($data[0] == 1) { // send notification when workflow is completed
            $email = new SendWorkflowCompleted($this->workflowversion[0], $this->workflow[0]['id']);
        }
        if($data[2] == 1) { // archive workflow
            WorkflowTemplateTable::instance()->archiveWorkflow($this->workflowversion[0]['id']);
        }

        if($data[3] == 1) { // delete workflow
            WorkflowTemplateTable::instance()->deleteWorkflow($this->workflowversion[0]['id']);
        }
    }


}
?>
