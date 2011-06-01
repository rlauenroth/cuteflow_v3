<?php
/**
 * Class builds the Menue for RegionWest in Extjs
 */

class Menue extends MenueCredential {

    private $userright;
    
    public function __construct() {
        sfLoader::loadHelpers('I18N');
        $this->moduleCounter = 0;
        $this->groupCounter = 0;
        $this->firstRun = true;
    }

    /**
     * Store userrights
     * @param array $right_in , set Userrights to an array
     */
    public function setUserRight($right_in) {
        $this->userright = $right_in;
    }


    /**
     *
     * Function overrides buildTree and returns array for menue on region west.
     *
     * @param array $credentials, is null
     * @return array $result, resultset
     */
    public function buildTree() {
        $result = array();
        foreach($this->records as $item) {
            $module = '';
            $module = $this->checkModule($result,$item->getUserModule());
            if($module != '') {
                $result[$this->moduleCounter]['user_module']['title'] = $module;
                $result[$this->moduleCounter]['user_module']['id'] = 'user_module_' . $module;
                $result[$this->moduleCounter]['user_module']['server_id'] = $module;
                $result[$this->moduleCounter]['user_module']['user_module'] = $module;
                $result[$this->moduleCounter]['user_module']['icon'] = 'user_module_' . $module . '_Icon';
                $result[$this->moduleCounter]['user_module']['position'] = $item->getUserModulePosition();
                $result[$this->moduleCounter]['user_module']['translation'] = $this->context->getI18N()->__($module ,null,'credential');
                $result[$this->moduleCounter]['user_module']['user_group'] = '';
            }

            $group = '';
            $group = $this->checkGroup($result[$this->moduleCounter],$item->getUserGroup());
            if($group != ''){
                $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['database_id'] = $item->getId();
                $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['title'] = $group;
                $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['id'] = $result[$this->moduleCounter]['user_module']['id'] . '_user_group_' . $group;
                $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['icon'] = $result[$this->moduleCounter]['user_module']['id'] . '_user_groupIcon_' . $group;
                $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['server_id'] = $group;
                $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['user_group'] = $group;
                $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['disabled'] = $this->checkRight($result[$this->moduleCounter]['user_module']['title'] . '_' . $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['title'] . '_showModule');
                $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['object'] = $result[$this->moduleCounter]['user_module']['title'] .'_' .$group;
                $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['translation'] = $this->context->getI18N()->__($group ,null,'credential');
                $result[$this->moduleCounter]['user_module']['user_group'][$this->groupCounter]['position'] = $item->getUserGroupPosition();
            }
        }
        $result = $this->sortMenue($result);
        return $result;
     }


     /**
      * Function rebuilds whole array, to sort it.
      *
      * @param array $data, $data with unsorted menue
      * @return array $data, $data sorted.
      */
     private function sortMenue(array $data) {
        $sort = array();
        $count = 0;
        for($a=0;$a<count($data);$a++) {
            $data = $this->sortArray($data, 'cmpModule');
            for($b=0;$b<count($data[$a]['user_module']['user_group']);$b++) {
                $sort = $this->sortArray($data[$a]['user_module']['user_group'], 'cmpGroup');
                $data[$a]['user_module']['user_group'] = $sort;
            }
        }
        return $data;
     }

     /**
      *
      * Function sorts the navigation of groups by position
      *
      * @param array $data
      * @return <type>
      */
     private function sortArray(array $data, $function) {
        usort($data, $function);
        return $data;
     }
         
     /**
      * return the right, according to an item
      * @param String $item, The right
      * @return boolean, true or false, if right is set
      */
     private function checkRight($item) {
         return  $this->user_right[$item];
     }




}

/**
 * Sort function for Menue
 * @param String $a
 * @param String $b
 * @return <type>
 */
function cmpModule($a, $b) {
    return strcmp($a['user_module']['position'], $b['user_module']['position']);
}
/**
 * Sort function for Groups
 * @param String $a
 * @param String $b
 * @return <type>
 */
function cmpGroup ($a, $b) {
    return strcmp($a['position'], $b['position']);
}
?>