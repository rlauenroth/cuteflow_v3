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
    public function setUserright($right_in) {
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
                $result[$this->moduleCounter]['usermodule']['title'] = $module;
                $result[$this->moduleCounter]['usermodule']['id'] = 'usermodule_' . $module;
                $result[$this->moduleCounter]['usermodule']['server_id'] = $module;
                $result[$this->moduleCounter]['usermodule']['usermodule'] = $module;
                $result[$this->moduleCounter]['usermodule']['icon'] = 'usermodule_' . $module . '_Icon';
                $result[$this->moduleCounter]['usermodule']['position'] = $item->getUsermoduleposition();
                $result[$this->moduleCounter]['usermodule']['translation'] = $this->context->getI18N()->__($module ,null,'credential');
                $result[$this->moduleCounter]['usermodule']['usergroup'] = '';
            }

            $group = '';
            $group = $this->checkGroup($result[$this->moduleCounter],$item->getUserGroup());
            if($group != ''){
                $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['database_id'] = $item->getId();
                $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['title'] = $group;
                $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['id'] = $result[$this->moduleCounter]['usermodule']['id'] . '_usergroup_' . $group;
                $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['icon'] = $result[$this->moduleCounter]['usermodule']['id'] . '_usergroupIcon_' . $group;
                $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['server_id'] = $group;
                $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['usergroupe'] = $group;
                $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['disabled'] = $this->checkRight($result[$this->moduleCounter]['usermodule']['title'] . '_' . $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['title'] . '_showModule');
                $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['object'] = $result[$this->moduleCounter]['usermodule']['title'] .'_' .$group;
                $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['translation'] = $this->context->getI18N()->__($group ,null,'credential');
                $result[$this->moduleCounter]['usermodule']['usergroup'][$this->groupCounter]['position'] = $item->getUsergroupposition();
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
            for($b=0;$b<count($data[$a]['usermodule']['usergroup']);$b++) {
                $sort = $this->sortArray($data[$a]['usermodule']['usergroup'], 'cmpGroup');
                $data[$a]['usermodule']['usergroup'] = $sort;
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
         return  $this->userright[$item];
     }




}

/**
 * Sort function for Menue
 * @param String $a
 * @param String $b
 * @return <type>
 */
function cmpModule($a, $b) {
    return strcmp($a['usermodule']['position'], $b['usermodule']['position']);
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