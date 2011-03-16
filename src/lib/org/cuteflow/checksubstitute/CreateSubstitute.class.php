<?php
/**
 * Calculates the next useragent for an process.
 */
class CreateSubstitute {

    public $process;
    public $numberCronjobOfSubstitutes;
    public $currentTime;
    public $checkSubObj;

    /**
     * Set time and check for Substitute.
     *
     * @param array $process, set the new process
     */
    public function  __construct(CheckSubstitute $obj, array $process) {
        $this->checkSubObj = $obj;
        $this->process = $process;
        $this->setCurrenTime(); // date of today
        $this->checkSubstitute();
    }


    /**
     * Function checks if a substitue is neede to set or not
     */
    public function checkSubstitute() {
        if($this->process['hasSubstitute'] == 0) { // no substitute for current process is set
            $writePermission = $this->checkDecissionStateOfSubstitute($this->process['inprogresssince']);
            if($writePermission == true){
                $this->setNewUserAgent($this->process['useragents'][0], $this->process['useragenttime']*2,0);
            }
        }
        else { // a substitute is set
            $this->getNumberOfCronjobSubstitutes(); // check if the substitute is set by cronjob, and out of the substitute list of the user
            // deaktivate the substitute, which is not set from a cronjob
            if($this->numberCronjobOfSubstitutes == 0) { // no substitute is set by the cronjob.
                $writePermission = $this->checkDecissionStateOfSubstitute($this->process['inprogresssince']);
                if($writePermission == true){
                    $this->disableUserAgent($this->process['workflowprocess_id'], 1);
                    $this->disableUserAgent($this->process['workflowprocess_id'], 0);
                    $this->setNewUserAgent($this->process['useragents'][0], $this->process['useragenttime']*2,0);
                }
            }
            else {
                $this->removeNoneCronjobSubstitutes();
                $minUserProcessTime = $this->process['useragenttime'];
                $mountOfUserAgents = sizeof($this->process['substitutes']);// returns the mount of useragents set
                for($a=0;$a<$mountOfUserAgents;$a++) {
                    $minUserProcessTime += $this->process['useragenttime'];
                }
                $nextUserAgent = $this->getNextUserAgent($mountOfUserAgents); // check if theres a next useragent
                if(is_array($nextUserAgent) == true) {
                    if($this->currentTime > ($this->process['inprogresssince']+$minUserProcessTime)) {
                
                        $this->disableUserAgent($this->process['workflowprocess_id'], 1);
                        $this->disableUserAgent($this->process['workflowprocess_id'], 0);
                        $this->setNewUserAgent($nextUserAgent, ($minUserProcessTime+$this->process['useragenttime']),$mountOfUserAgents);
                    }
                }
 
            }
        }
    }

    /**
     * Remove the substitutes which are not created by the cronjob
     */
    public function removeNoneCronjobSubstitutes() {
        $a = 0;
        $result = array();
        foreach($this->process['substitutes'] as $substitute) {
            if($substitute['useragentsetbycronjob'] == 1) {
                $result[$a++] = $substitute;
            }
        }
        unset($this->process['substitutes']);
        $this->process['substitutes'] = $result;
    }

    /**
     *
     * @param int $wfProcessId, id of the process which is top stop
     * @param boolean $flag, 1 to set cronjobprocesses disabled, 0 to set nonprocesses to disabled
     */
    public function disableUserAgent($wfProcessId, $flag) {
        WorkflowProcessUserTable::instance()->setProcessToUseragentSetByCronjobAndByProcessId($wfProcessId, $flag);
    }


    /**
     * Recursive function, which calculates and creates a useragent.
     * The Function calculates out of an timestamp the next useragent
     *
     * The $sumUseragenttime variable is summed up by each set useragent.
     * $sumUseragenttime = $sumUseragenttime + (mountofUseragents * userUserSetinngsUserAgenttime)
     *
     * @param array $userAgent, current Useragent
     * @param int $sumUseragenttime, useragent time which is summed up by each written useragent
     * @param int $userAgentOffset, offset for the array
     */
    public function setNewUserAgent(array $userAgent, $sumUseragenttime, $userAgentOffset) {
        
        if($this->checkSubObj->cronJobSetting == 1){
            if($this->currentTime > ($sumUseragenttime + $this->process['inprogresssince'])) {
                $decissionstate = 'USERAGENTSET';
                $userAgentOffset++;
                $nextUserAgent = $this->getNextUserAgent($userAgentOffset);
                if(is_array($nextUserAgent) == true) { // a useragent was found
                    $sumUseragenttime = $sumUseragenttime + $this->process['useragenttime'];
                    WorkflowProcessUserTable::instance()->setProcessToUseragentSet($this->process['id']);
                    $processObj = new WorkflowProcessUser();
                    $processObj->setWorkflowprocessId($this->process['workflowprocess_id']);
                    $processObj->setWorkflowslotuserId($this->process['workflowslotuser_id']);
                    $processObj->setUserId($userAgent['useragent_id']);
                    $processObj->setInprogresssince(time());
                    $processObj->setDateofdecission(time());
                    $processObj->setDecissionstate('USERAGENTSET');
                    $processObj->setUseragentsetbycronjob(1);
                    $processObj->setIsuseragentof($this->process['id']);
                    $processObj->setResendet(0);
                    $processObj->save();
                    $this->setNewUserAgent($nextUserAgent, $sumUseragenttime, $userAgentOffset);
                }
                else { // last Useragent in list is selected
                    $decissionstate = 'WAITING';
                }
            }
            else {
                $decissionstate = 'WAITING';
            }
        }
        else {
            $decissionstate = 'WAITING';
        }

        if($decissionstate == 'WAITING') {
            WorkflowProcessUserTable::instance()->setProcessToUseragentSet($this->process['id']);
            $processObj = new WorkflowProcessUser();
            $processObj->setWorkflowprocessId($this->process['workflowprocess_id']);
            $processObj->setWorkflowslotuserId($this->process['workflowslotuser_id']);
            $processObj->setUserId($userAgent['useragent_id']);
            $processObj->setInprogresssince(time());
            $processObj->setDateofdecission(time());
            $processObj->setDecissionstate('WAITING');
            $processObj->setUseragentsetbycronjob(1);
            $processObj->setIsuseragentof($this->process['id']);
            $processObj->setResendet(0);
            $processObj->save();
            // get Additional Data, to send an email
            $workflowSettings = WorkflowProcessTable::instance()->getWorkflowProcessById($this->process['id']);
            $workflowVersionTable = WorkflowVersionTable::instance()->getWorkflowVersionById($workflowSettings[0]->getWorkflowversionId())->toArray();

            // sendmail
            $mailObj = new PrepareStationEmail($workflowVersionTable[0]['id'], $workflowVersionTable[0]['workflowtemplate_id'], $userAgent['useragent_id'], $this->checkSubObj->context, $this->checkSubObj->serverUrl);
        }
    
    }


    /**
     * return a useragent of a user
     * @param int $offset, offset in the array
     * @return false if theres no next useragent, array if theres a useragent
     */
    public function getNextUserAgent($offset) {
        if(isset($this->process['useragents'][$offset]) == true) {
            return  ($this->process['useragents'][$offset]);
        }
        else {
            return false;
        }

    }

    /**
     * Check if theres a need to write a useragent
     * @param int $inprogress, timestamp
     * @return true if writing is needed, false if not
     */
    public function checkDecissionStateOfSubstitute($inprogress) {
        if($this->currentTime > ($inprogress + $this->process['useragenttime'])) {
            return true;
        }
        return false; // no need to write a new useragent
    }


    /**
     * Calculate the numer of users, which were set by cronjob
     */
    public function getNumberOfCronjobSubstitutes() {
        $this->numberCronjobOfSubstitutes = 0;
        foreach($this->process['substitutes'] as $substitute) {
            if($substitute['useragentsetbycronjob'] == 1) {
                $this->numberCronjobOfSubstitutes += 1;
            }
        }
    }

   /**
    * set current time
    */
   public function setCurrenTime() {
        $this->currentTime = time();
    }








}
?>
