<?php
/**
 * Class that handles the language operation
 *
 * @author Manuel Schäfer
 */
class UserRolemanagement {

    public function __construct() {

    }

    /**
     * Function loads all Roles and builds output for ExtJS
     *
     * @param Doctrine_Collection $data
     * @param int $index, number to count
     * @return array $result, resultset for grid
     */
    public function buildRole(Doctrine_Collection $data, $index) {

        $result = array();
        $a = 0;
        foreach($data as $item) {
            $result[$a]['#'] = $index++;
            $result[$a]['id'] = $item->getId();
            $result[$a]['users'] = $item->getUsers();
            $result[$a++]['description'] = $item->getDescription();
        }
        return $result;
    }



    /**
     *
     * Builds role for extjs combobox
     *
     * @param Doctrine_Collection $data, resultset
     * @return array $result, resultset for role combox
     */
    public function buildRoleCombobox(Doctrine_Collection $data) {

        $result = array();
        $a = 0;
        foreach($data as $item) {
            $result[$a]['value'] = $item->getId();
            $result[$a++]['text'] = $item->getDescription();
        }
        return $result;
    }    

}

?>