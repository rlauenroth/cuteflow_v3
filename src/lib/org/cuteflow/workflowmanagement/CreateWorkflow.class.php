<?php


/**
 * Class creates a new Worklow, and can be used for the cronjob, when a worklow must
 * be started in the future
 */
class CreateWorkflow{


    private $version_id;
    private $workflow_id;
    private $slots;
    public $context;
    public $serverUrl;

    /**
     *
     * @param int $version_in, the id of the current workflowversion needs to be setted.
     */
    public function  __construct($version_in) {
        $this->version_id = $version_in;
        $this->getSlots($this->version_id);
        $this->setWorkflowId();
    }

    public function setServerUrl($url) {
        $this->serverUrl = $url;
    }
    
    
    public function setContext(sfContext $context) {
        $this->context = $context;
    }

    /**
     * Load all Workflowslots for an workflowversion
     */
    public function getSlots() {
        $this->slots = WorkflowSlotTable::instance()->getSlotByVersionId($this->version_id);
    }

    /**
     * Set the workflowtemplate id
     */
    public function setWorkflowId() {
        $workflow = WorkflowVersionTable::instance()->getWorkflowVersionById($this->version_id)->toArray();
        $this->workflow_id = $workflow[0]['workflow_template_id'];
    }

    /**
     * is called when only a single slot is needed to set
     */
    public function addSingleSlot() {
        $slotObj = new CreateSlot($this->slots[0], $this->version_id, $this->workflow_id, $this);
    }

    /**
     * is calles when all slots needed to be set at once
     */
    public function addAllSlots() {
        foreach($this->slots as $slot) {
            $slotObj = new CreateSlot($slot, $this->version_id, $this->workflow_id, $this);
        }

    }



    


}
?>