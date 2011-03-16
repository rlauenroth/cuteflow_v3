<?php
/**
 * Class Loads all WAITING WorkflowProcesses with the possible useragents and substitutes
 *
 * If some processes are found, create SubStitute class for each process will be called
 *
 */
class CheckSubstitute {

    public $openProcesses;
    public $currentTime;
    public $serverUrl;
    public $context;
    public $cronJobSetting;


    public function __construct(Doctrine_Collection $openProcesses, $context, $serverUrl, $cronjobSetting) {
        $result = $this->checkForSubstitute($openProcesses);
        $this->cronJobSetting = $cronjobSetting;
        $this->severUrl = $serverUrl;
        $this->context = $context;
        $this->openProcesses = $result;
        $this->addUserAgentsAndUserSettingsAndTime();
        $this->checkTime();
    }


 

    /**
     * Function checks if the WAITING process is a substitute of an process.
     * If Yes, the StartProcess is loaded, and all substitutes were merged into the StartProcess
     * If No, nothing happens
     * @param Doctrine_Collection $openProcesses, WAITING processes
     * @return array $result, merged Array
     */
    public function checkForSubstitute($openProcesses) {
        $result = array();
        $b = 0;
        foreach($openProcesses as $process) {
            if($process['isuseragentof'] != '' AND is_numeric($process['isuseragentof']) == true) {
                $processAndSubstitutes = WorkflowProcessUserTable::instance()->getProcessAndSubstituteProcessByProcessId($process->getIsuseragentof())->toArray();
                $theProcessWithSubstitute = array();
                $theProcessWithSubstitute = $processAndSubstitutes[0];
                // add substitutes to the Process
                $counter = 0;
                for($a=1;$a<count($processAndSubstitutes);$a++) {
                    $theProcessWithSubstitute['hasSubstitute'] = 1;
                    $theProcessWithSubstitute['substitutes'][$counter++] = $processAndSubstitutes[$a];
                }
                $result[$b++] = $theProcessWithSubstitute;
            }
            else {
                $result[$b] = $process->toArray();
                $result[$b]['hasSubstitute'] = 0;
                $b++;
            }
        }
        return $result;
    }



    /**
     * Add the useragents for the user in the process to the array
     */
    public function addUserAgentsAndUserSettingsAndTime() {
        for($a=0;$a<count($this->openProcesses);$a++) {
            $user = UserAgentTable::instance()->getAllUserAgents($this->openProcesses[$a]['user_id'])->toArray(); // get useraegnts for the user
            if(empty($user) == true) {
                $this->openProcesses[$a]['hasUserAgent'] = 0;
            }
            else {
                $this->openProcesses[$a]['hasUserAgent'] = 1;
                $this->openProcesses[$a]['useragents'] = $user;
                $userSettings = UserSettingTable::instance()->getUserSettingById($this->openProcesses[$a]['user_id'])->toArray();
                $this->openProcesses[$a]['usersettings'] = $userSettings[0];
                $this->openProcesses[$a]['useragenttime'] = $this->calculateUserAgentTime($userSettings[0]['durationtype'],$userSettings[0]['durationlength']);
            }
        } 
    }

    /**
     * Check only entries of the process, where a useragent can be set
     */
    public function checkTime() {
        foreach($this->openProcesses as $process) {
            // check only entries, where a useragent is set
            if($process['hasUserAgent'] == 1) {
                $sub = new CreateSubstitute($this, $process);
            }
        }
    }


    /**
     * Return the useragent timesettings of an user in seconds
     *
     * @param String $type, the type, can be days, hours or minutes
     * @param int $length, lengt as digit
     * @return int $timeInSeconds, useragent time in seconds
     */
    public function calculateUserAgentTime($type, $length) {
        switch($type){
            case 'DAYS':
                $timeInSeconds = $length * 24 * 60 * 60;
                break;
            case 'HOURS':
                $timeInSeconds = $length * 60 * 60;
                break;
            case 'MINUTES':
                $timeInSeconds = $length * 60;
                break;
        }
        return $timeInSeconds;
    }

    
    



}
?>
