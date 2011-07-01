<?php

class WorkflowSetStation {


    public function __construct() {
        
    }


    public function getNextUser($workflow_slot_id, $position) {
        $user = WorkflowSlotUserTable::instance()->getUserBySlotIdAndPosition($workflow_slot_id, $position)->toArray();
        return $user;
    }
    

    public function getNextSlot($version_id, $position) {
        $slot = WorkflowSlotTable::instance()->getSlotByWorkflowversionAndPosition($version_id, $position)->toArray();
        return $slot;
    }


   public function calculateSlot($workflow_slot_id) {
       $currentSlot = WorkflowSlotTable::instance()->getSlotById($workflow_slot_id)->toArray();
       $nextSlot = $this->getNextSlot($currentSlot[0]['workflow_version_id'],$currentSlot[0]['position']+1);
       if(!empty($nextSlot)) {
           $this->calculateStation($nextSlot[0]['id'], 1);
       }
   }

   public function calculateStation($workflow_slot_id, $position) {
       
   }
    
}
?>