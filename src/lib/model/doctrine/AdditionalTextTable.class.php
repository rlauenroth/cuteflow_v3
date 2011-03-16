<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class AdditionalTextTable extends Doctrine_Table {


    /**
     *
     * create new instance of AdditionalText
     * @return object UserLoginTable
     */
    public static function instance() {
        return Doctrine::getTable('AdditionalText');
    }

    /**
     * Load all additional textes
     *
     * @return Doctrine_Collection
     */
    public function getAllAdditionalTextes() {
        return Doctrine_Query::create()
            ->from('AdditionalText at')
            ->select('at.*')
            ->orderBy('at.id DESC')
            ->where('at.deleted_at IS NULL')
            ->execute();
    }

    /**
     * Activates (set text to standard) an additional text
     * 
     * @param int $id, entry which is to set active
     * @return boolean true
     */
    public function setActive($id) {
        Doctrine_Query::create()
            ->update('AdditionalText at')
            ->set('at.isactive','?',0)
            ->execute();
        Doctrine_Query::create()
            ->update('AdditionalText at')
            ->set('at.isactive','?',1)
            ->where('at.id = ?', $id)
            ->execute();

       return true;
    }


    /**
     * Loads a single Additional Text by its Id
     * @param int $id, id of the text to load
     * @return Doctrine_Collection
     */
    public function findSingleTextById($id) {
        return Doctrine_Query::create()
            ->from('AdditionalText at')
            ->select('at.*')
            ->where('at.id = ?', $id)
            ->andWhere('at.deleted_at IS NULL')
            ->execute();
    }

    /**
     *´update an additional Text
     * 
     * @param array $data
     * @param string $id, of the record to change
     * @return true
     */
    public function updateText($data, $id) {
        Doctrine_Query::create()
            ->update('AdditionalText at')
            ->set('at.title','?',$data['title'])
            ->set('at.contenttype','?',$data['contenttype'])
            ->set('at.content','?',$data['content'])
            ->where('at.id = ?', $id)
            ->execute();
        return true;
    }


    /**
     * Deletes an additional text
     * @param int $id, entry to delete
     * @return true
     */
    public function deleteText($id) {
        Doctrine_Query::create()
            ->update('AdditionalText at')
            ->set('at.deleted_at','?', date('Y-m-d'))
            ->where('at.id = ?',$id)
            ->execute();
        return true;
    }
    
}