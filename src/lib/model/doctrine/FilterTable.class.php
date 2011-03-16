<?php

class FilterTable extends Doctrine_Table {

    /**
     *
     * create new instance of AdditionalText
     * @return object UserLoginTable
     */
    public static function instance() {
        return Doctrine::getTable('Filter');
    }



    public function getAllFilter() {
        return Doctrine_Query::create()
           ->select('f.*')
           ->from('Filter f')
           ->orderBy('f.id ASC')
           ->execute();
        
    }

    public function getFilterById($id) {
        return Doctrine_Query::create()
           ->select('f.*, ff.*')
           ->from('Filter f')
           ->leftJoin('f.FilterField ff')
           ->where('f.id = ?', $id)
           ->orderBy('f.id ASC')
           ->execute();

    }

}