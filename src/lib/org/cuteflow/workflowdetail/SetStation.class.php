<?php

/**
 * Class sets another station if selected by sender
 */

class SetStation {

    public $version_id;
    public $workflow_template_id;
    public $newWorkflowSlotUser_id;
    public $currentWorkflowSlotUser_id;
    public $move;

    public $context;
    public $serverUrl;

    public $currentWorkflowSlot;
    public $currentWorkflowSlotUser;

    public $currentSlotSendToAllReceiver;
    public $newSlotSendToAllReceiver;

    public $newWorkflowSlot;
    public $newWorkflowSlotUser;


    /**
     *
     * @param int $version_id, id of workflow version
     * @param int $newWorkflowSlotUser_id, station id which is to set
     * @param int $currentWorkflowSlotUser_id, station id of the current user
     * @param String $move, direction can be UP or DOWN
     * @param sfContext $context
     * @param String $serverUrl 
     */
    public function  __construct($version_id,$newWorkflowSlotUser_id, $currentWorkflowSlotUser_id, $move, sfContext $context, $serverUrl) {
        $this->context = $context;
        $this->serverUrl = $serverUrl;
        $this->version_id = $version_id;
        $this->newWorkflowSlotUser_id = $newWorkflowSlotUser_id;
        $this->currentWorkflowSlotUser_id = $currentWorkflowSlotUser_id;
        $this->move = $move;
        $this->setWorkflowTemplateId();
        $this->setCurrentWorkflowSlotUser();
        $this->setCurrentWorkflowSlot();
        $this->setNewWorkflowslotUser();
        $this->setNewSlot();
        
        $this->setCurrentSlotSendToAllReceiver();
        $this->setNewSlotSendToAllReceiver();
        $this->makeDecission();
    }

    public function setContext(sfContext $context) {
        $this->context = $context;
    }

    public function setServerUrl($url) {
        $this->serverUrl = $url;
    }

    public function setCurrentSlotSendToAllReceiver() {
        $slot = $this->currentWorkflowSlot->getDocumentTemplateSlot()->toArray();
        $this->currentSlotSendToAllReceiver = $slot[0]['send_to_all_receivers'];
    }

    public function setNewSlotSendToAllReceiver() {
        $slot = $this->newWorkflowSlot->getDocumentTemplateSlot()->toArray();
        $this->newSlotSendToAllReceiver = $slot[0]['send_to_all_receivers'];

    }

    
    public function setWorkflowTemplateId() {
        $template = WorkflowVersionTable::instance()->getWorkflowVersionById($this->version_id);
        $this->workflow_template_id = $template[0]->getWorkflowTemplateId();
    }

    public function setNewWorkflowslotUser() {
        $user = WorkflowSlotUserTable::instance()->getUserById($this->newWorkflowSlotUser_id);
        $this->newWorkflowSlotUser = $user[0];
    }

    public function setNewSlot() {
        $slot = WorkflowSlotTable::instance()->getSlotById($this->newWorkflowSlotUser->getWorkflowSlotId());
        $this->newWorkflowSlot = $slot[0];
    }


    public function setCurrentWorkflowSlotUser() {
        $user = WorkflowSlotUserTable::instance()->getUserById($this->currentWorkflowSlotUser_id);
        $this->currentWorkflowSlotUser = $user[0];
    }


    public function setCurrentWorkflowSlot() {
        $slot = WorkflowSlotTable::instance()->getSlotById($this->currentWorkflowSlotUser->getWorkflowSlotId());
        $this->currentWorkflowSlot = $slot[0];
    }



    public function makeDecission() {
        if($this->move == 'DOWN') {
            $calc = new MoveDown($this);
        }
        else { // move = UP
            $calc = new MoveUp($this);
        }
        
    }


    

    










}

















?>