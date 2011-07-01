<?php
/**
 * class Handles Login functionality and loads userrights
 *
 */
class Login {

    public function __construct() {

    }

    public static function getBackgroundColor() {
       $config =  SystemConfigurationTable::instance()->getSystemConfiguration()->toArray();
       return $config[0]['color_of_north_region'];
    }

    /**
     *
     * This function loads from js/i18n/XXX/ext-lang-XX.js
     * the folder to load JS language files
     *
     * @param String $culture, the current Culture of the user.
     * @return String, default Language or culture if language exists
     */
    public static function buildExtjsLanguage($culture) {
        $folder = sfConfig::get('sf_web_dir') . '/js/i18n/' . $culture;
        if(is_dir($folder)) {
            return $culture;
        }
        else {
            return sfConfig::get('sf_default_culture');
        }

    }

    /**
     * Function loads all userrights for an exisitng user. If an right is set, false will return, if a
     * right is not set, true is returned. On EXTJS Frontend, modules are enabled with the tag 'disabled'.
     *
     * @param Doctrine_Collection $credentials, all rights in the system
     * @param Doctrine_Collection $userright, rights of the user
     * @return array $result, all rights for the user
     */
    public function loadUserRight(Doctrine_Collection $credentials, Doctrine_Collection $userright) {
        $credential_arr = $this->buildCredentials($credentials);
        $user_arr = $this->buildUserRight($userright);
        $result = array();
        for($a=0;$a<count($credential_arr);$a++){
            if(in_array($credential_arr[$a]['id'], $user_arr) == TRUE) {
                $result[$credential_arr[$a]['right']] = 'false';
            }
            else {
                $result[$credential_arr[$a]['right']] = 'true';
            }
        }
        return $result;
    }


    /**
     * Function builds out of the doctrine collection an array with all credentials in the system
     *
     * @param Doctrine_Collection $credentials
     * @return array $result, resultset
     */
    private function buildCredentials(Doctrine_Collection $credentials) {
        $result = array();
        $a = 0;
        foreach($credentials as $item) {
            $result[$a]['id'] = $item->getId();
            $result[$a++]['right'] = $item->getUserModule() . '_' . $item->getUserGroup() . '_' . $item->getUserRight();
        }
        return $result;
    }


    /**
     * Creates array out of the collection
     *
     * @param Doctrine_Collection $userright, Doctrine Collection with current userrights
     * @return array $result, resultset
     */
    private function buildUserRight(Doctrine_Collection $userright) {
        $result = array();
        foreach($userright as $item) {
            $result[] = $item->getCredentialId();
        }
        return $result;
    }

    /**
     * Check if system is already installed
     * @return <type>
     */
    public function checkInstaller() {
        $file = sfConfig::get('sf_root_dir') . '/config/installed';
        if(file_exists($file) == true) {
            return true;
        }
        else {
            return false;
        }

    }

    /**
     *
     * Generates the columns for grid, in workflow overivew, todo and archvie
     *
     * @param array $data, columns
     * @param sfContext $context, context
     * @return array $result
     */
    public function generateUserWorklowView(array $data, sfContext $context) {
        $a = 0;
        foreach($data as $item) {
            $result[$a]['column_text'] = $item['column_text'];
            $result[$a]['hidden'] = $item['is_active'] == 'true' ? 'false' : 'true';
            $result[$a]['field_id'] = -1;
            $result[$a]['text'] = $context->getI18N()->__($item['column_text'] ,null,'system_setting');
            switch($item['column_text']) {
                case 'NAME':
                    $result[$a]['store'] = 'name';
                    $result[$a]['width'] = '140';
                    break;
                case 'STATION':
                    $result[$a]['store'] = 'currentstation';
                    $result[$a]['width'] = '180';
                    break;
                case 'DAYS':
                    $result[$a]['store'] = 'stationrunning';
                    $result[$a]['width'] = '130';
                    break;
                case 'START':
                    $result[$a]['store'] = 'version_created_at';
                    $result[$a]['width'] = '120';
                    break;
                case 'SENDER':
                    $result[$a]['store'] = 'sendername';
                    $result[$a]['width'] = '200';
                    break;
                case 'TOTALTIME':
                    $result[$a]['store'] = 'currentlyrunning';
                    $result[$a]['width'] = '80';
                    break;
                case 'MAILINGLIST':
                    $result[$a]['store'] = 'mailinglisttemplate';
                    $result[$a]['width'] = '150';
                    break;
                case 'USERDEFINED1':
                    if($item['field_id'] != '' AND is_numeric($item['field_id']) == true AND $item['is_active'] == 'true') {
                        $fieldName = FieldTable::instance()->getFieldById($item['field_id']);
                        $result[$a]['text'] = $fieldName[0]->getTitle();
                        $result[$a]['store'] = 'userdefined1';
                        $result[$a]['field_id'] = $item['field_id'];
                        $result[$a]['width'] = '100';
                    }
                    else {
                        $result[$a]['width'] = '100';
                        $result[$a]['store'] = 'userdefined1';
                    }
                    break;
                case 'USERDEFINED2':
                    if($item['field_id'] != '' AND is_numeric($item['field_id']) == true AND $item['is_active'] == 'true') {
                        $fieldName = FieldTable::instance()->getFieldById($item['field_id']);
                        $result[$a]['text'] = $fieldName[0]->getTitle();
                        $result[$a]['store'] = 'userdefined2';
                        $result[$a]['field_id'] = $item['field_id'];
                        $result[$a]['width'] = '100';
                    }
                    else {
                        $result[$a]['width'] = '100';
                        $result[$a]['store'] = 'userdefined2';
                    }
                    break;
            }
            $a++;
        }

        return @$result;
        
    }



}
?>