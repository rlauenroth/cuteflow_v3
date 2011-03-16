<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class DocumenttemplateFieldTable extends Doctrine_Table {

    /**
     * create new instance of FormTemplate
     * @return object FormTemplate
     */
    public static function instance() {
        return Doctrine::getTable('DocumenttemplateField');
    }

    /**
     *
     * Get all fields by slot id
     * @param int $id
     * @return Doctrine_Collection
     */
    public function getAllFieldsBySlotId($id) {
        return Doctrine_Query::create()
            ->select('dtf.*')
            ->from('DocumenttemplateField dtf')
            ->where('dtf.documenttemplateslot_id = ?', $id)
            ->orderBy('dtf.position asc')
            ->execute();
        
    }
}