<?php
/**
 * Class enables to change the order of the menue items
 */

class MenueSetting extends MenueCredential {

    

    public function __construct() {
        sfLoader::loadHelpers('I18N');
    }


    /**
     * Function builds Data for Menue Settings Grid
     *
     * @param Doctrine_Collection $data, Data with all Menues
     * @return array $result, resultset with all elements
     */
    public function buildModule(Doctrine_Collection $data) {
        $result = array();
        $a = 0;

        foreach($data as $item) {
            $result[$a]['#'] = $a+1;
            $result[$a]['id'] = $item->getUsermodule();
            $result[$a]['group'] = $this->context->getI18N()->__($item->getUsermodule() ,null,'credential');
            $result[$a++]['module'] = $item->getUsermodule();
        }
       return $result;
    }

    /**
     * Function builds all data for the Grid of an Module
     *
     * @param Doctrine_Collection $data, data with data of all SubMenues (groups)
     * @return array $result, resultset with all elements
     */
    public function buildGroup(Doctrine_Collection $data) {
        $result = array();
        $a = 0;
        
        foreach($data as $item) {
            $result[$a]['#'] = $a+1;
            $result[$a]['module_id'] = $item->getUsermodule();
            $result[$a]['module'] = $this->context->getI18N()->__($item->getUsermodule() ,null,'credential');
            $result[$a]['group_id'] = $item->getUsergroup();
            $result[$a++]['group'] = $this->context->getI18N()->__($item->getUsergroup() ,null,'credential');
        }
        return $result;
    }


    
}
?>