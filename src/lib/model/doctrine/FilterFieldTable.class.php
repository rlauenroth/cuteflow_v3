<?php

class FilterFieldTable extends Doctrine_Table {



    /**
     * create new instance of FormTemplate
     * @return object FormTemplate
     */
    public static function instance() {
        return Doctrine::getTable('FilterField');
    }


    public function getFilterFieldByFilterId($id) {
        return Doctrine_Query::create()
           ->select('ff.*')
           ->from('FilterField ff')
           ->where('ff.filter_id = ?', $id)
           ->orderBy('ff.id ASC')
           ->execute();
    }

    public function deleteFieldsByFilterId($id) {
        Doctrine_Query::create()
            ->delete('FilterField')
            ->from('FilterField f')
            ->where('f.filter_id = ?', $id)
            ->execute();
        return true;
    }




}