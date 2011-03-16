<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class WorkflowVersionAttachmentTable extends Doctrine_Table {

    /**
     *
     * create new instance of AdditionalText
     * @return object UserLoginTable
     */
    public static function instance() {
         return Doctrine::getTable('WorkflowVersionAttachment');
    }


    public function getAttachmentsByVersionId($versionId) {
        return Doctrine_Query::create()
            ->from('WorkflowVersionAttachment wva')
            ->select('wva.*')
            ->where('wva.workflowversion_id = ?', $versionId)
            ->execute();
    }

    public function getAttachmentsById($id) {
        return Doctrine_Query::create()
            ->from('WorkflowVersionAttachment wva')
            ->select('wva.*')
            ->where('wva.id = ?', $id)
            ->execute();
    }
}