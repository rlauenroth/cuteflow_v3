<?php
/**
 * Class that handles the language operation
 *
 * @author Manuel Schäfer
 */
class Usermanagement {

    public function __construct() {

    }



    /**
     * Function builds the data for the Extjs Grid, to change the order
     * of circulation overview Columns.
     *
     * @param array $data
     * @param sfContext, Context symfony object
     * @return array $data, resultset
     */
    public function buildUserColumns(array $data, sfContext $context) {
        for($a = 0;$a<count($data);$a++) {
            $data[$a]['column'] = $data[$a]['column_text'];
            $data[$a]['column_text'] = $context->getI18N()->__($data[$a]['column_text'],null,'systemsetting');

        }
        return $data;
    }
    /**
     *
     * Function creates resultset for ExtJS Grid
     *
     * @param Doctrine_Collection $data, results
     * @param int $index, Index for Paging
     * @return array $result, resultset
     */
    public function buildUser(Doctrine_Collection $data, $index) {
        $result = array();
        $a = 0;

        foreach($data as $item) {
            $role = $item->getRole();
            $userdata = $item->getUserData();
            $result[$a]['id'] = $item->getId();
            $result[$a]['#'] = $index++;
            $result[$a]['firstname'] = $userdata->getFirstname();
            $result[$a]['lastname'] = $userdata->getLastname();
            $result[$a]['email'] = $item->getEmail();
            $result[$a]['username'] = $item->getUsername();
            $result[$a]['role_id'] = $role->getId();
            $result[$a]['role_description'] = $role->getDescription();
            $result[$a++]['action'] = $item->getId();
        }
        return $result;
    }

    public static function checkLDAP () {
        $result = AuthenticationConfigurationTable::instance()->getAuthenticationType();
        if($result[0]->getAuthenticationType() == 'DATABASE_LDAP') {
            return 'false';
        }
        else {
            return 'true';
        }
    }

    /**
     * Function builds Role for Extjs
     *
     * @param Doctrine_Collection $data
     * @param int $index, index for counter
     * @return array $result, resultset
     */
    public function buildRole(Doctrine_Collection $data, $index) {

        $result = array();
        $a = 0;
        foreach($data as $item) {
            $result[$a]['#'] = $index++;
            $result[$a]['id'] = $item->getId();
            $result[$a++]['description'] = $item->getDescription();
        }
        return $result;
    }

    /**
     *  Builds data for the superselectbox in edit / new User
     *
     * @param Doctrine_Collection $data, data
     * @return array $result
     */
    public function buildUserGrid(Doctrine_Collection $data) {
        $result = array();
        $a = 0;
        foreach($data as $item) {
            $data = $item->toArray();
            $result[$a]['id'] = $item->getUserId();
            $result[$a]['unique_id'] = $a;
            $result[$a]['username'] = $item->getText() . ' <i>('.$data['UserLogin']['username'].')</i>';
            $result[$a++]['text'] = $item->getText();
        }
        return $result;

    }


    /**
     * Function loads useragents when in editmode.
     *
     * @param Doctrine_Collection $data, data with all useragents
     * @return array $result, resultset for the grid
     */
    public function builUserAgentGrid(Doctrine_Collection $data) {
        $result = array();
        $a = 0;
        foreach($data as $item) {
            $user = $item->getUserData();
            $result[$a]['databaseId'] = $item->getId();
            $result[$a]['unique_id'] = $a;
            $result[$a]['user_id'] = $item->getUserAgentId();
            $result[$a++]['text'] = $user[0]->getFirstname() . ' ' . $user[0]->getLastname();
        }
        return $result;
    }


    /**
    * Loads all data for a user, when editing user
    *
    * @param Doctrine_Collection $data, data for a single user
    * @return array $result, returns an resultset with items
    */
    public function buildSingleUser(Doctrine_Collection $data) {
        $result = array();

        foreach($data as $item) {

            $userdata = $item->getUserData();
            $usersettings = $item->getUserSetting();
            $userrole = $item->getRole();
            
            $result['id'] = $item->getId();
            $result['username'] = $item->getUsername();
            $result['firstname'] = $userdata->getFirstname();
            $result['lastname'] = $userdata->getLastname();
            $result['email'] = $item->getEmail();
            $result['password'] = $item->getPassword();
            
            $result['role_id'] = $item->getRoleId();
            $result['rolename'] = $userrole->getDescription();
            $result['street'] = $userdata->getStreet();
            $result['zip'] = $userdata->getZip();
            $result['city'] = $userdata->getCity();
            $result['country'] = $userdata->getCountry();
            $result['phone1'] = $userdata->getPhone1();
            $result['phone2'] = $userdata->getPhone2();
            $result['mobil'] = $userdata->getMobile();
            $result['fax'] = $userdata->getFax();
            $result['organisation'] = $userdata->getOrganisation();
            $result['department'] = $userdata->getDepartment();
            $result['burdencenter'] = $userdata->getBurdencenter();
            $result['comment'] = $userdata->getComment();


            $result['language'] = $usersettings->getLanguage();
            $result['duration_length'] = $usersettings->getDurationLength();
            $result['duration_type'] = $usersettings->getDurationType();
            $result['mark_yellow'] = $usersettings->getMarkYellow();
            $result['mark_red'] = $usersettings->getMarkRed();
            $result['mark_orange'] = $usersettings->getMarkOrange();
            $result['refresh_time'] = $usersettings->getRefreshTime();
            $result['displayed_item'] = $usersettings->getDisplayedItem();
            $result['email_format'] = $usersettings->getEmailFormat();
            $result['email_type'] = $usersettings->getEmailType();
            $result['circulation_default_sort_column'] = $usersettings->getCirculationDefaultSortColumn();
            $result['circulation_default_sort_direction'] = $usersettings->getCirculationDefaultSortDirection();
        }
        return $result;
    }


}
?>