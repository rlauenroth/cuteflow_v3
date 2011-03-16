<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class WorkflowSlotFieldTable extends Doctrine_Table {

    public static function instance() {
        return Doctrine::getTable('WorkflowSlotField');
    }



    public function getWorkflowSlotFieldBySlotId($id) {
        return Doctrine_Query::create()
            ->from('WorkflowSlotField wsf')
            ->select('wsf.*,')
            ->where('wsf.workflowslot_id = ?' ,$id)
            ->orderBy('wsf.position ASC')
            ->execute();
    }


    public function getWorkflowSlotFieldBySlotIdWithValues($id) {
        return Doctrine_Query::create()
            ->from('WorkflowSlotField wsf')
            ->select('wsf.*,wsft.*')
            ->where('wsf.workflowslot_id = ?' ,$id)
            ->orderBy('wsf.position ASC')
            ->execute();
    }



    public function getWorkflowSlotFieldBySlotIdAndFieldId($slotid, $fieldid) {
        return Doctrine_Query::create()
            ->from('WorkflowSlotField wsf')
            ->select('wsf.*')
            ->where('wsf.workflowslot_id = ?' ,$slotid)
            ->andWhere('wsf.field_id = ?', $fieldid)
            ->orderBy('wsf.position ASC')
            ->execute();
    }

    

}