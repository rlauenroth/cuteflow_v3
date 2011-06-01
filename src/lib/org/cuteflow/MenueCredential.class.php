<?php

/**
 * Parent class to create Menue (Navigation West) and Userrolemanagement Popup
 * 
 * @author Manuel Schaefer
 */
class MenueCredential {
    
    public $records;
    public $moduleCounter;
    public $groupCounter;
    public $firstRun;
    public $rightCounter;
    public $context;



    public function setRecords(Doctrine_Collection $records_in) {
        $this->records = $records_in;
    }


    public function setContext(sfContext $context_in) {
        $this->context = $context_in;
    }


    /**
     *
     * Function checks when role is edited, if a checkbox is set or not
     *
     * @param int $item, id of the item
     * @param array $credentials, credentials for the role.....
     * @return boolean, true if role is active, false if not.
     */
    public function checkChecked($item, array $credentials) {
        if(in_array($item, $credentials) == true) {
            return 1;
        }
        else {
            return 0;
        }
    }


    /**
     * Function checks for equal group in the resultset and the current item
     * if a group is already in the resultset, nothing is done.
     * If group is not in resultset, tab is added.
     *
     * @param array $result, Resultset with the current data
     * @param string $item, value of the current item
     * @return string $item, retursn item or nothing.
     */
    public function checkGroup($result, $item) {
        $flag = false;
        if ($this->firstRun == false OR $this->groupCounter > 0) {
            foreach($result['user_module']['user_group'] as $group) {
                if($group['server_id'] == $item) {
                    $flag = true;
                }
            }
            if($flag == false) {
                $this->groupCounter++;
                $this->rightCounter = 0;
                return $item;
            }

        }
        else {
            $this->firstRun = false;
            return $item;
        }

    }

    /**
     * Function checks for equal tabs in the resultset and the current item
     * if a tab is already in the resultset, nothing is done.
     * If tab is not in resultset, tab is added.
     *
     * @param array $result, Resultset with the current data
     * @param string $item, value of the current item
     * @return string $item, retursn item or nothing.
     */
    public function checkModule($result, $item) {
        $flag = false;
        if ($this->firstRun == false OR $this->moduleCounter > 0) {
            foreach($result as $module) {
                if($module['user_module']['title'] == $item) {
                    $flag = true;
                }
            }

            if($flag == false) {
                $this->moduleCounter++;
                $this->groupCounter = 0;
                $this->rightCounter = 0;
                $this->firstRun = true;
                return $item;
            }
            else {
                return '';
            }
        }
        else {
            //$this->firstRun = false;
            return $item;
        }
    }

    /**
     * Checks for Parent item.
     * Parent item must be: showModule
     *
     * @param String $item
     * @return boolean, 1 for is Parent, 0 for non-parent
     */
    public function checkParent($item) {
        if($item == 'showModule') {
            return 1;
        }
        else {
            return 0;
        }
    }

    /**
     * Function sorts the builded tree, that module enabling is on top of an array.
     * Necessarry that in ExtJS frontend, the fat black module name is on top.
     *
     * @param array $data
     * @return array $data
     */
    public function sortGroup(array $data) {
        $store_showModule = array();
        $store_firtsElement = array();

        for($a=0;$a<count($data);$a++) {
            for($b=0;$b<count($data[$a]['user_module']['user_group']);$b++) {
                for($c=0;$c<count($data[$a]['user_module']['user_group'][$b]['user_right']);$c++) {
                    if($data[$a]['user_module']['user_group'][$b]['user_right'][$c]['server_id'] == 'showModule') {
                        if($c > 0) {
                            $store_showModule = $data[$a]['user_module']['user_group'][$b]['user_right'][$c];
                            $store_firtsElement = $data[$a]['user_module']['user_group'][$b]['user_right'][0];
                            $data[$a]['user_module']['user_group'][$b]['user_right'][$c] = $store_firtsElement;
                            $data[$a]['user_module']['user_group'][$b]['user_right'][0] = $store_showModule;
                        }
                    }
                }
            }
        }
        return $data;
    }


    /**
     *
     * Function builds an array out of the collection
     *
     * @param Doctrine_Collection $data
     * @return array $result, resultset
     */
    public function buildCredentials(Doctrine_Collection $data) {
        $result = array();
        foreach($data as $item) {

            $result[] = $item->getCredentialId();
        }
        return $result;
    }

}
?>