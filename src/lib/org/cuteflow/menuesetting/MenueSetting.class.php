<?php
/**
 * Class enables to change the order of the menue items
 */

class MenueSetting extends MenueCredential {

    

    public function __construct() {
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
            $result[$a]['id'] = $item->getUserModule();
            $result[$a]['group'] = $this->context->getI18N()->__($item->getUserModule() ,null,'credential');
            $result[$a++]['module'] = $item->getUserModule();
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
            $result[$a]['module_id'] = $item->getUserModule();
            $result[$a]['module'] = $this->context->getI18N()->__($item->getUserModule() ,null,'credential');
            $result[$a]['group_id'] = $item->getUserGroup();
            $result[$a++]['group'] = $this->context->getI18N()->__($item->getUserGroup() ,null,'credential');
        }
        return $result;
    }


    
}
?>