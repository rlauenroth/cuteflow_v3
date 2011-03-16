<?php

class WorkflowSetStation {


    public function __construct() {
        
    }


    public function getNextUser($workflowslot_id, $position) {
        $user = WorkflowSlotUserTable::instance()->getUserBySlotIdAndPosition($workflowslot_id, $position)->toArray();
        return $user;
    }
    

    public function getNextSlot($version_id, $position) {
        $slot = WorkflowSlotTable::instance()->getSlotByWorkflowversionAndPosition($version_id, $position)->toArray();
        return $slot;
    }


   public function calculateSlot($workflowslot_id) {
       $currentSlot = WorkflowSlotTable::instance()->getSlotById($workflowslot_id)->toArray();
       $nextSlot = $this->getNextSlot($currentSlot[0]['workflowversion_id'],$currentSlot[0]['position']+1);
       if(!empty($nextSlot)) {
           $this->calculateStation($nextSlot[0]['id'], 1);
       }
   }

   public function calculateStation($workflowslot_id, $position) {
       
   }
    
}
?>