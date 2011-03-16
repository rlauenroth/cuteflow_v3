<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class WorkflowSlotTable extends Doctrine_Table {
     /**
      * 
     * create new instance of FormTemplate
     * @return object FormTemplate
     */
    public static function instance() {
        return Doctrine::getTable('WorkflowSlot');
    }

    /**
     *
     * Get the first Slot of a new Workflow
     *
     * @param int $version_id, current version
     * @param int $template_id, current template
     * @return Doctrine_Collection
     */
    public function getFirstSlotOfNewCirculation($version_id, $template_id) {
        return Doctrine_Query::create()
            ->select('wfs.*')
            ->from('WorkflowSlot wfs')
            ->leftJoin('wfs.WorkflowVersion wfv')
            ->where('wfv.id = ?', $version_id)
            ->andWhere('wfv.workflowtemplate_id = ?', $template_id)
            ->orderBy('wfs.position ASC')
            ->execute();
    }


    public function getFieldBySlotIdAndFieldId($fieldId, $version_id) {
        return Doctrine_Query::create()
            ->select('wfs.*, wfsf.id as workflowslotfieldid')
            ->from('WorkflowSlot wfs')
            ->leftJoin('wfs.WorkflowSlotField wfsf')
            ->where('wfs.workflowversion_id = ?', $version_id)
            ->andWhere('wfsf.field_id = ?', $fieldId)
            ->orderBy('wfs.position ASC')
            ->execute();
    }



    public function getSlotByVersionId($version_id) {
        return Doctrine_Query::create()
            ->select('wfs.*')
            ->from('WorkflowSlot wfs')
            ->where('wfs.workflowversion_id = ?', $version_id)
            ->orderBy('wfs.position ASC')
            ->execute();
    }


    public function getSlotById($id) {
        return Doctrine_Query::create()
            ->select('wfs.*')
            ->from('WorkflowSlot wfs')
            ->where('wfs.id = ?', $id)
            ->orderBy('wfs.position ASC')
            ->execute();
    }

    public function getSlotByWorkflowversionAndPosition($workflowversionid, $position) {
        return Doctrine_Query::create()
            ->select('wfs.*')
            ->from('WorkflowSlot wfs')
            ->where('wfs.workflowversion_id = ?', $workflowversionid)
            ->andWhere('wfs.position = ?', $position)
            ->orderBy('wfs.position ASC')
            ->execute();
    }


    public function getSlotWithUserByVersionId($version_id) {
        return Doctrine_Query::create()
            ->select('wfs.*, wfsu.*')
            ->from('WorkflowSlot wfs')
            ->leftJoin('wfs.WorkflowSlotUser wfsu')
            ->where('wfs.workflowversion_id = ?', $version_id)
            //->andWhere('wfsu.workflowslot_id = ?', 'wfs.id')
            ->orderBy('wfs.position ASC')
            ->execute();

    }


}