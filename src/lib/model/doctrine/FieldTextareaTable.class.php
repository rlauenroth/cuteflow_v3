<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class FieldTextareaTable extends Doctrine_Table {
    /**
     *
     * create new instance of FieldTextareaTable
     * @return object FieldTextareaTable
     */
    public static function instance() {
        return Doctrine::getTable('FieldTextarea');
    }

    /**
     * Update Textarea by id
     * @param int $id, id of number
     * @param array $data, data to update
     * @return true
     */
    public function updateFieldTextareaById($id, $data) {
        Doctrine_Query::create()
            ->update('FieldTextarea fta')
            ->set('fta.contenttype','?', $data['fieldTextarea_contenttype'])
            ->set('fta.content','?',$data['fieldTextarea_content'])
            ->where('fta.field_id = ?',$id)
            ->execute();
        return true;
    }

    /**
     * Get content of a field by its id
     * @param int $id, id of the field
     * @return Doctrine_Collection
     */
    public function getTextareaByFieldId($id) {
        return Doctrine_Query::create()
            ->select('fta.*')
            ->from('FieldTextarea fta')
            ->where('fta.field_id = ?', $id)
            ->execute();
    }


    public function getTextareaById($id) {
        return Doctrine_Query::create()
            ->select('fta.*')
            ->from('FieldTextarea fta')
            ->where('fta.field_id = ?', $id)
            ->execute();
    }


}