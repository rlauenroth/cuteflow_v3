<?php
/**
 * Class that handles the system settings operation
 *
 * @author Manuel Schäfer
 */
class SystemSetting {


    public function __construct() {
        sfLoader::loadHelpers('I18N');
        sfLoader::loadHelpers('EndAction');
    }


    /**
     *
     *  Get Values, if Position in mail is shown
     *
     * @return array $result
     */
    public static function getShowPositionInMail() {
        $data = SystemConfigurationTable::instance()->getSystemConfiguration()->toArray();
        $result = array();
        if($data[0]['showpositioninmail'] == 1) {
            $result['hidden'] = 'false';
            $result['collapsible'] = 'true';
        }
        else {
            $result['hidden'] = 'true';
            $result['collapsible'] = 'false';
        }
        return $result;
    }



    /**
     * Prepare data for useragent settings
     *
     * @param array $data
     * @return <type>
     */
    public function prepareUserAgentData(array $data) {
        $data['useragent_useragentsettings'] = isset($data['useragent_useragentsettings']) ? 1 : 0;
        $data['useragent_useragentcreation'] = isset($data['useragent_useragentcreation']) ? 1 : 0;
        $data['writeDays'] = 0;
        if($data['useragent_useragentsettings'] == 1) {
            $data['writeDays'] = 1;
            $data['counter'] = 0;
            if(isset($data['useragenttime'])) {
                foreach($data['useragenttime'] as $count) {
                    $data['counter'] += $count;
                }
            }
        }
        return $data;
        
    }

    /**
     * Function builds the data for the Extjs Grid, to change the order
     * of circulation overview Columns.
     *
     * @param array $data
     * @param sfContext, Context symfony object
     * @return array $data, resultset
     */
    public function buildColumns(array $data, sfContext $context) {
        for($a = 0;$a<count($data);$a++) {
            $data[$a]['column'] = $data[$a]['columntext'];
            $data[$a]['columntext'] = $context->getI18N()->__($data[$a]['columntext'],null,'systemsetting');

        }
        return $data;
    }


    /**
     * Cleans data updating the system settings
     *
     * @param array $data
     * @return array $data
     */
    public function buildSystemSetting(array $data) {
        $data['systemsetting_showposition'] = isset($data['systemsetting_showposition']) ? $data['systemsetting_showposition'] : 0;
        $data['systemsetting_allowunencryptedrequest'] = isset($data['systemsetting_allowunencryptedrequest']) ? $data['systemsetting_allowunencryptedrequest'] : 0;
        $data['systemsetting_sendreceivermail'] = isset($data['systemsetting_sendreceivermail']) ? $data['systemsetting_sendreceivermail'] : 0;
        $data['systemsetting_sendremindermail'] = isset($data['systemsetting_sendremindermail']) ? $data['systemsetting_sendremindermail'] : 0;
        return $data;
    }

    /**
     * Cleans data for updating email settings
     * @param array $data
     * @return array $data
     */
    public function buildEmailSetting(array $data) {
        $data['emailtab_encryption'] = $data['emailtab_encryption'] == 'NONE' ? '' : $data['emailtab_encryption'];
        //$data['email_smtp_auth'] = isset($data['email_smtp_auth']) ? 1 : 0;
        $data['email_allowsendingemails'] = isset($data['emailtab_allowsendingemails']) ? 1 : 0;
        return $data;
    }


    /**
     * Cleans data for updating user settings
     * @param array $data
     * @return array $data
     */
    public function buildUserSetting(array $data) {
        $data['userTab_markred'] = $data['userTab_markred'] == '' ? 12 : $data['userTab_markred'];
        $data['userTab_markyellow'] = $data['userTab_markyellow'] == '' ? 7 : $data['userTab_markyellow'];
        $data['userTab_markorange'] = $data['userTab_markorange'] == '' ? 10 : $data['userTab_markorange'];
        $data['userTab_defaultdurationlength'] = $data['userTab_defaultdurationlength'] == '' ? 3 : $data['userTab_defaultdurationlength'];
        return $data;
    }


    /**
     * Loads firstlogin flag
     *
     * @return bool true/false
     */
    public static function getFirstLogin() {
        $result = AuthenticationConfigurationTable::instance()->getFirstLogin()->toArray();
        return $result[0]['firstlogin'];
    }

    /**
     * Function builds the data for the Extjs Grid, to change the order
     * of circulation overview Columns.
     *
     * @param array $data
     * @param sfContext, Context symfony object
     * @return array $data, resultset
     */
    public function buildAuthorizationColumns(array $data, sfContext $context) {
        
        $result = array();
        $a = 0;
        foreach($data as $item) {
            $result[$a]['type'] = $context->getI18N()->__($item['type'],null,'systemsetting');
            $result[$a]['raw_type'] = $item['type'];
            $result[$a]['id'] = $item['id'];
            $result[$a]['isRole'] = false;
            $result[$a]['roleId'] = -1;
            $result[$a]['deleteworkflow'] = $item['deleteworkflow'];
            $result[$a]['archiveworkflow'] = $item['archiveworkflow'];
            $result[$a]['stopneworkflow'] = $item['stopneworkflow'];
            $result[$a++]['detailsworkflow'] = $item['detailsworkflow'];
        }
        return $result;
    }


    /**
     * build individual cronjob settings
     *
     * @param array $data cronjob data
     * @param sfContext $context
     * @return array $result
     */
    public function buildUserAgent(array $data, sfContext $context) {
        
        $result['individualcronjob'] = $data[0]['individualcronjob'];
        $result['setuseragenttype'] = $data[0]['setuseragenttype'];
        $result['cronjobdays'] = $this->getDays($this->getRunningDays($data[0]['cronjobdays'],7));
        $result['cronjobfrom'] = $data[0]['cronjobfrom'];
        $result['cronjobto'] = $data[0]['cronjobto'];
        $result['datestore'] = $this->getDate($context);
        return $result;
    }

    /**
     * Get days for their shortcut
     *
     * @param array $date
     * @return array $result
     */
    public function getDays(array $date) {
        $result['mon'] = $date[6];
        $result['tue'] = $date[5];
        $result['wed'] = $date[4];
        $result['thu'] = $date[3];
        $result['fri'] = $date[2];
        $result['sat'] = $date[1];
        $result['son'] = $date[0];
        return $result;
    }

    
    public function getRunningDays($number, $count = 5) {
        $bin =  decbin ($number);
	$a = strlen($bin);
	for($a = strlen($bin);$a<$count;$a++) {
		$bin = '0' . $bin;
	}
	$array = str_split ($bin);
	return $array;
    }


    /**
     *
     * @param sfContext $context
     * @return <type>
     */
    public function getDate($context) {
        $result = array();
        $a = 0;
        $hour[0]['name'] =  $context->getI18N()->__('01:00' ,null,'cronjobsetting');
        $hour[1]['name'] =  $context->getI18N()->__('02:00' ,null,'cronjobsetting');
        $hour[2]['name'] =  $context->getI18N()->__('03:00' ,null,'cronjobsetting');
        $hour[3]['name'] =  $context->getI18N()->__('04:00' ,null,'cronjobsetting');
        $hour[4]['name'] =  $context->getI18N()->__('05:00' ,null,'cronjobsetting');
        $hour[5]['name'] =  $context->getI18N()->__('06:00' ,null,'cronjobsetting');
        $hour[6]['name'] =  $context->getI18N()->__('07:00' ,null,'cronjobsetting');
        $hour[7]['name'] =  $context->getI18N()->__('08:00' ,null,'cronjobsetting');
        $hour[8]['name'] =  $context->getI18N()->__('09:00' ,null,'cronjobsetting');
        $hour[9]['name'] =  $context->getI18N()->__('10:00' ,null,'cronjobsetting');
        $hour[10]['name'] =  $context->getI18N()->__('11:00' ,null,'cronjobsetting');
        $hour[11]['name'] =  $context->getI18N()->__('12:00' ,null,'cronjobsetting');
        $hour[12]['name'] =  $context->getI18N()->__('13:00' ,null,'cronjobsetting');
        $hour[13]['name'] =  $context->getI18N()->__('14:00' ,null,'cronjobsetting');
        $hour[14]['name'] =  $context->getI18N()->__('15:00' ,null,'cronjobsetting');
        $hour[15]['name'] =  $context->getI18N()->__('16:00' ,null,'cronjobsetting');
        $hour[16]['name'] =  $context->getI18N()->__('17:00' ,null,'cronjobsetting');
        $hour[17]['name'] =  $context->getI18N()->__('18:00' ,null,'cronjobsetting');
        $hour[18]['name'] =  $context->getI18N()->__('19:00' ,null,'cronjobsetting');
        $hour[19]['name'] =  $context->getI18N()->__('20:00' ,null,'cronjobsetting');
        $hour[20]['name'] =  $context->getI18N()->__('21:00' ,null,'cronjobsetting');
        $hour[21]['name'] =  $context->getI18N()->__('22:00' ,null,'cronjobsetting');
        $hour[22]['name'] =  $context->getI18N()->__('23:00' ,null,'cronjobsetting');
        $hour[23]['name'] =  $context->getI18N()->__('24:00' ,null,'cronjobsetting');

        $hour[0]['value'] =  '01';
        $hour[1]['value'] =  '02';
        $hour[2]['value'] =  '03';
        $hour[3]['value'] =  '04';
        $hour[4]['value'] =  '05';
        $hour[5]['value'] =  '06';
        $hour[6]['value'] =  '07';
        $hour[7]['value'] =  '08';
        $hour[8]['value'] =  '09';
        $hour[9]['value'] =  '10';
        $hour[10]['value'] =  '11';
        $hour[11]['value'] =  '12';
        $hour[12]['value'] =  '13';
        $hour[13]['value'] =  '14';
        $hour[14]['value'] =  '15';
        $hour[15]['value'] =  '16';
        $hour[16]['value'] =  '17';
        $hour[17]['value'] =  '18';
        $hour[18]['value'] =  '19';
        $hour[19]['value'] =  '20';
        $hour[20]['value'] =  '21';
        $hour[21]['value'] =  '22';
        $hour[22]['value'] =  '23';
        $hour[23]['value'] =  '24';
        return $hour;
    }

}
?>