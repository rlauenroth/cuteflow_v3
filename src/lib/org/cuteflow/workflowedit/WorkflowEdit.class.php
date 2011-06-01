<?php

class WorkflowEdit {

    private $context;
    private $user;
    private $culture;
    private $helperFlag;
    public $serverUrl;
    
    public function  __construct($loadHelper = true) {
        $this->helperFlag = $loadHelper;
        if($loadHelper == true) {
            $this->loadHelper();
            $this->setServerUrl(url_for('layout/index',true));
        }
    }


    public function loadHelper() {
        sfLoader::loadHelpers('Date');
        sfLoader::loadHelpers('Url');
        sfLoader::loadHelpers('CalculateDate');
        sfLoader::loadHelpers('ColorBuilder');
        sfLoader::loadHelpers('I18N');
        sfLoader::loadHelpers('Icon');
    }


    public function setContext ($context_in) {
        $this->context = $context_in;
    }

    public function setCulture($culture_in) {
        $this->culture = $culture_in;
    }

    public function setUser(myUser $user_in) {
        $this->user = $user_in->getAttribute('id');
    }

    public function setUserId($userId) {
        $this->user = $userId;
    }

    public function setServerUrl($url) {
        $url = str_replace('/layout', '', $url);
        $this->serverUrl = $url;
    }

    public function buildSlots(Doctrine_Collection $data, $version_id) {
        
        $result = array();
        $mergedResult = array();
        $a = 0;
        $slots = WorkflowSlotTable::instance()->getSlotByVersionId($version_id);
        foreach($slots as $slot) {
            $slotname = $slot->getDocumenttemplateSlot()->toArray();
            $result[$a]['workflowslot_id'] = $slot->getId();
            $result[$a]['slot_id'] = $slot->getSlotId();
            $result[$a]['version_id'] = $slot->getId();
            $result[$a]['slotname'] = $slotname[0]['name'];
            $result[$a]['fields'] = $this->getFields($slot, $version_id);
            $result[$a]['isdisabled'] = $this->checkSlotVisability($slot->getId());

            $a++;
        }
        $mergedResult = $this->mergeArray($result, $version_id);
        return $mergedResult;
    }

    private function checkSlotVisability($workflowslot_id) {
        $activeUser = array();
        $activeUser = WorkflowProcessUserTable::instance()->getActiveProcessUserForWorkflowSlot($workflowslot_id,$this->user)->toArray();
        if(empty($activeUser) == true) {
            return 1;
        }
        else {
            return 0;
        }
    }




    private function getFields(WorkflowSlot $slot, $versionid) {
        $result = array();
        $a = 0;
        $fields = WorkflowSlotFieldTable::instance()->getWorkflowSlotFieldBySlotIdWithValues($slot->getId());
        $workflowDetail = new WorkflowDetail($this->helperFlag);
        $workflowDetail->setServerUrl($this->serverUrl);
        $column = 'LEFT';
        foreach($fields as $field) {
            $docField = $field->getField()->toArray();
            $result[$a]['workflowslotfield_id'] = $field->getId();
            $result[$a]['workflowslot_id'] = $field->getWorkflowslotId();
            $result[$a]['fieldname'] = $docField[0]['title'];
            $result[$a]['type'] = $docField[0]['type'];
            if($column == 'LEFT') {
                $column = 'RIGHT';
                $result[$a]['column'] = 'LEFT';
            }
            else {
                $column = 'LEFT';
                $result[$a]['column'] = 'RIGHT';
            }
            $result[$a]['writeprotected'] = $docField[0]['writeprotected'];
            $result[$a]['color'] = $docField[0]['color'];
            $result[$a]['items'] = $workflowDetail->getFieldItems($field,$docField[0]['type'], $this->context, $versionid);
            $a++;
            
        }
        return $result;
    }



    public function stopWorkflow($workflow_id, $version_id, $user_id, $endreason) {
        WorkflowTemplateTable::instance()->stopWorkflow($workflow_id, $user_id);
        WorkflowVersionTable::instance()->setEndReason($version_id, $endreason);
        WorkflowProcessUserTable::instance()->setWaitingStationToStoppedByUser($version_id);
    }


    private function mergeArray(array $result) {
        $return = array();
        $activeSlot = array();
        $inacitveSlot = array();
        $systemSettings = SystemConfigurationTable::instance()->getSystemConfiguration()->toArray();
        $a = 0;
        $b = 0;

        if($systemSettings[0]['visible_slots'] == 'CURRENT') {
            foreach($result as $slot) {
                if($slot['isdisabled'] == 0) {
                    $return[$a++] = $slot;
                }
            }
            return $return;

        }
        elseif($systemSettings[0]['visible_slots'] == 'TOPMOST') {
            foreach($result as $slot) {
                if($slot['isdisabled'] == 0) {
                    $activeSlot[$a++] = $slot;
                }
                else {
                    $inacitveSlot[$b++] = $slot;
                }
            }
            $a = 0;
            foreach($activeSlot as $slot) {
                $return[$a++] = $slot;
            }
            foreach($inacitveSlot as $slot) {
                $return[$a++] = $slot;
            }
            return $return;
        }
        else {
            return $result;
        }
        

    }







}

?>