<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class SystemConfigurationTable extends Doctrine_Table {

    /**
     * create new instance of SystemConfigurationTable
     * @return object SystemConfigurationTable
     */
    public static function instance() {
        return Doctrine::getTable('SystemConfiguration');
    }

    /**
     * Loads System config
     * @return Doctrine_Collection
     */
    public function getSystemConfiguration() {
        return Doctrine_Query::create()
                ->select('sc.*')
                ->from('SystemConfiguration sc')
                ->execute();
    }

    /**
     * Update system configuration
     * @param array $data
     * @return <type>
     */
    public function updateSystemConfiguration (array $data) {
        Doctrine_Query::create()
            ->update('SystemConfiguration sc')
            ->set('sc.language','?',$data['systemsetting_language'])
            ->set('sc.showpositioninmail','?',$data['systemsetting_showposition'])
            ->set('sc.sendreceivermail','?',$data['systemsetting_sendreceivermail'])
            ->set('sc.sendremindermail','?',$data['systemsetting_sendremindermail'])
            ->set('sc.visibleslots','?',$data['systemsetting_slotvisible'])
            ->set('sc.colorofnorthregion','?',$data['systemsetting_color'])
            ->where ('sc.id = ?',1)
            ->execute();
        return true;
    }


    public function updateUserAgent(array $data) {
        $query = Doctrine_Query::create()
            ->update('SystemConfiguration sc')
            ->set('sc.individualcronjob','?',$data['useragent_useragentsettings'])
            ->set('sc.setuseragenttype','?',$data['useragent_useragentcreation']);
        if($data['writeDays'] == 1) {
            $query->set('sc.cronjobdays','?',$data['counter'])
                  ->set('sc.cronjobfrom','?',$data['useragent_useragentsettings_from'])
                  ->set('sc.cronjobto','?',$data['useragent_useragentsettings_to']);
        }
            $query->where ('sc.id = ?',1)
                  ->execute();
        return true;
    }

}