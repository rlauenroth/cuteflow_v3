<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class UserConfigurationTable extends Doctrine_Table {


    /** 
     * create new instance of UserConfiguration
     * @return object UserConfiguration
     */
    public static function instance() {
        return Doctrine::getTable('UserConfiguration');
    }

    /**
     * Loads User config
     * @return Doctrine_Collection
     */
    public function getUserConfiguration() {
        return Doctrine_Query::create()
                ->select('uc.*')
                ->from('UserConfiguration uc')
                ->execute();
    }

    /**
     * Updates User settings
     * @param array $data
     * @return true
     */
    public function updateUserConfiguration (array $data) {
        Doctrine_Query::create()
            ->update('UserConfiguration uc')
            ->set('uc.duration_type', '?', $data['userTab_defaultdurationtype'])
            ->set('uc.duration_length', '?', $data['userTab_defaultdurationlength'])
            ->set('uc.displayed_item', '?', $data['userTab_itemsperpage'])
            ->set('uc.refresh_time', '?', $data['userTab_refreshtime'])
            ->set('uc.mark_yellow', '?', $data['userTab_markyellow'])
            ->set('uc.mark_red', '?', $data['userTab_markred'])
            ->set('uc.mark_orange', '?', $data['userTab_markorange'])
            ->set('uc.language', '?', $data['userTab_language'])
            ->set('uc.password', '?', $data['userTab_defaultpassword'])
            ->set('uc.email_format', '?', $data['userTab_emailformat'])
            ->set('uc.email_type', '?', $data['userTab_emailtype'])
            ->set('uc.circulationdefaultsortcolumn', '?', $data['userTab_circulationdefaultsortcolumn'])
            ->set('uc.circulationdefaultsortdirection', '?', $data['userTab_circulationdefaultsortdirection'])
            ->set('uc.role_id', '?', $data['userTab_userrole'])
            ->where('uc.id = ?',1)
            ->execute();
        return true;
    }

    public function updateTheme($theme) {
        Doctrine_Query::create()
            ->update('UserConfiguration uc')
            ->set('uc.theme', '?', $theme)
            ->where('uc.id = ?',1)
            ->execute();
        return true;

    }
}