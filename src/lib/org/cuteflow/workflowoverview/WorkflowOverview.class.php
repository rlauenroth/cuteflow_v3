<?php



class WorkflowOverview {

    private $context;
    private $userId;
    private $culture;
    private $user;

    public function  __construct(sfContext $context_in, myUser $user) {
        require_once sfConfig::get('sf_root_dir') . '/lib/helper/CalculateDateHelper.php';  
        require_once sfConfig::get('sf_root_dir') . '/lib/helper/ColorBuilderHelper.php';  
        require_once sfConfig::get('sf_root_dir') . '/lib/vendor/symfony/helper/DateHelper.php';  
        $this->context = $context_in;
        $this->user = $user;
    }


    public function setUserId($id) {
        $this->userId = $id;
    }

    public function setCulture($culture) {
        $this->culture = $culture;
    }

    public function buildData(Doctrine_Collection $data, $counter) {
        $result = array();
        $a = 0;
        $counter++;
        $authSettings = new CreateWorkflowAuthorizationRights();
        $authSettings->setDefaultRole();
        $authSettings->setUserRole($this->userId);
        $userSettings = $this->user->getAttribute('userSettings');
        foreach($data as $item) {
            $sender = UserLoginTable::instance()->findActiveUserById($item->getSenderId());
            $mailinglist = MailinglistTemplateTable::instance()->getMailinglistByVersionId($item->getMailinglistTemplateVersionId());
            $inProgress = createDayOutOfDateSince($item->getVersionCreatedAt());
            $inProgress = addColor($inProgress, $userSettings['markred'],$userSettings['markorange'],$userSettings['markyellow']);
            $userdata = $sender[0]->getUserData()->toArray();
            $username = $sender[0]->getUsername() . ' (' . $userdata['firstname'] . ' ' . $userdata['lastname'] . ')';
            $result[$a]['#'] = $counter++;;
            $result[$a]['id'] = $item->getId();
            $result[$a]['mailinglist_template_id'] = $item->getMailinglistTemplateVersionId();
            $result[$a]['mailinglisttemplate'] = $mailinglist[0]->getName();
            $result[$a]['sender_id'] = $item->getSenderId();
            $result[$a]['sendername'] = $username;
            
            $result[$a]['name'] = $item->getName();
            $result[$a]['isstopped'] = $item->getIsStopped();
            $result[$a]['process'] = $this->getProcess($item->getActiveVersionId());
            $result[$a]['auth'] = $authSettings->getRights($item->getMailinglistTemplateVersionId(), $item->getActiveVersionId());
            if($item->getIsCompleted() == 0 OR $item->getIsCompleted() == '') {
                 $result[$a]['is_completed'] = 0;
            }
            else {
                $result[$a]['is_completed'] = 1;
                $result[$a]['process'] = '<div style="background-color:#00FF00; width:100px;">100 %'.'</div>';
            }

            $result[$a]['workflow_is_started'] = $item->getWorkflowIsStarted();
            if($item->getIsStopped() == 1) {
                $result[$a]['currentstation'] = '<table><tr><td width="16"><img src="/images/icons/circ_stop.gif" /></td><td>'.$this->context->getI18N()->__('Workflow stopped' ,null,'workflowmanagement').'</td></tr></table>';
                $result[$a]['currentlyrunning'] = '-';
                $result[$a]['stationrunning'] = '-';
               // $result[$a]['process'] = '-';
            }
            elseif($item->getIsCompleted() == 1) {
                $result[$a]['currentstation'] = '<table><tr><td width="16"><img src="/images/icons/circ_done.gif" /></td><td>'.$this->context->getI18N()->__('Workflow completed' ,null,'workflowmanagement').'</td></tr></table>';
                $result[$a]['currentlyrunning'] = '-';
                $result[$a]['stationrunning'] = '-';
            }
            elseif($item->getWorkflowIsStarted() == 0) {
                $startdateofWorkflow = date('Y-m-d',$item->getStartWorkflowAt());
                $startdateofWorkflow = format_date($startdateofWorkflow, 'p', $this->culture);
                $result[$a]['currentstation'] = '<table><tr><td width="16"><img src="/images/icons/circ_waiting.gif" /></td><td>'.$this->context->getI18N()->__('Startdate' ,null,'workflowmanagement').': '.$startdateofWorkflow.'</td></tr></table>';
                $result[$a]['currentlyrunning'] = '-';
                $result[$a]['stationrunning'] = '-';
            }
            else {
                $stationSettings =  $this->getCurrentStation($item->getActiveVersionId(), $item->getSenderId());
                if(!empty($stationSettings)) {
                    $result[$a]['currentstation'] = $stationSettings[0];
                    $result[$a]['currentlyrunning'] = '<table><tr><td width="20">' . $inProgress . ' </td><td>' . $this->context->getI18N()->__('Day(s)' ,null,'workflowmanagement') . '</td></tr></table>';
                    $slotRunning = createDayOutOfDateSince($stationSettings[1]);
                    $slotRunning = addColor($slotRunning, $userSettings['markred'],$userSettings['markorange'],$userSettings['markyellow']);
                    $result[$a]['stationrunning'] = '<table><tr><td width="20">' . $slotRunning . ' </td><td>' . $this->context->getI18N()->__('Day(s)' ,null,'workflowmanagement') . '</td></tr></table>';
                }
                else {
                    $result[$a]['currentstation'] = '-';
                    $result[$a]['currentlyrunning'] = '-';
                    $result[$a]['stationrunning'] = '-';
                }
            }

            if($item->getIsArchived() == 1) {
                $result[$a]['currentstation'] = '<table><tr><td width="16"><img src="/images/icons/circ_archived.gif" /></td><td>'.$this->context->getI18N()->__('Workflow archived' ,null,'workflowmanagement').'</td></tr></table>';
                $result[$a]['currentlyrunning'] = '-';
                $result[$a]['stationrunning'] = '-';
            }


            $result[$a]['userdefined1'] = $this->getFields('userdefined1',$item->getActiveVersionId());
            $result[$a]['userdefined2'] = $this->getFields('userdefined2',$item->getActiveVersionId());

            $result[$a]['version_created_at'] = format_date($item->getVersionCreatedAt(), 'g', $this->culture);   
            $result[$a++]['active_version_id'] = $item->getActiveVersionId();
        }
        #print_r ($result);die;
        return $result;

    }


    /**
     * Get userdefined field
     *
     * @param String  $type, userdefined1, userdefined2
     */
    public function getFields($type, $versionId) {
        $view = $this->user->getAttribute('userWorkflowSettings');
        $result = '';
        foreach($view as $singleView) {
            if($singleView['store'] == $type AND $singleView['fieldid'] > -1) {
                $wfItem = WorkflowVersionTable::instance()->getFieldByWorkflowVersionIdAndFieldId($singleView['fieldid'], $versionId)->toArray();
                if(empty($wfItem) == true) {
                    return '';
                }
                else {
                    $slots = WorkflowSlotTable::instance()->getFieldBySlotIdAndFieldId($singleView['fieldid'], $versionId)->toArray();
                    $fields = WorkflowSlotFieldTable::instance()->getWorkflowSlotFieldBySlotIdAndFieldId($slots[0]['id'],$singleView['fieldid'])->toArray();
                    $theType = FieldTable::instance()->getFieldById($fields[0]['field_id'])->toArray();
                    if(!empty($theType)) {
                        switch ($theType[0]['type']) {
                            case 'TEXTFIELD':
                                $value = WorkflowSlotFieldTextfieldTable::instance()->getAllItemsByWorkflowFieldId($fields[0]['id'])->toArray();
                                $result = $value[0]['value'];
                                return $result;
                                break;
                            case 'CHECKBOX':
                                $value = WorkflowSlotFieldCheckboxTable::instance()->getAllItemsByWorkflowFieldId($fields[0]['id'])->toArray();
                                $result = $value[0]['value'] == 1 ? $this->context->getI18N()->__('Yes' ,null,'workflowmanagement') : $this->context->getI18N()->__('No' ,null,'workflowmanagement');
                                return $result;
                                break;
                            case 'NUMBER':
                                $value = WorkflowSlotFieldNumberTable::instance()->getAllItemsByWorkflowFieldId($fields[0]['id'])->toArray();
                                $result = $value[0]['value'];
                                return $result;
                                break;
                            case 'DATE':
                                $value = WorkflowSlotFieldDateTable::instance()->getAllItemsByWorkflowFieldId($fields[0]['id'])->toArray();
                                $result = $value[0]['value'];
                                return $result;
                                break;
                            case 'TEXTAREA':
                                $value = WorkflowSlotFieldTextareaTable::instance()->getAllItemsByWorkflowFieldId($fields[0]['id'])->toArray();
                                $result = $value[0]['value'];
                                return $result;
                                break;
                            case 'RADIOGROUP':
                                $value = WorkflowSlotFieldRadiogroupTable::instance()->getAllItemsByWorkflowFieldId($fields[0]['id'])->toArray();
                                $result = $value[0]['value'] == 1 ? $this->context->getI18N()->__('Yes' ,null,'workflowmanagement') : $this->context->getI18N()->__('No' ,null,'workflowmanagement');
                                return $result;
                                break;
                            case 'CHECKBOXGROUP':
                                $value = WorkflowSlotFieldCheckboxgroupTable::instance()->getAllItemsByWorkflowFieldId($fields[0]['id'])->toArray();
                                $result = $value[0]['value'] == 1 ? $this->context->getI18N()->__('Yes' ,null,'workflowmanagement') : $this->context->getI18N()->__('No' ,null,'workflowmanagement');
                                return $result;
                                break;
                            case 'COMBOBOX':
                                $value = WorkflowSlotFieldComboboxTable::instance()->getAllItemsByWorkflowFieldId($fields[0]['id'])->toArray();
                                $result = $value[0]['value'] == 1 ? $this->context->getI18N()->__('Yes' ,null,'workflowmanagement') : $this->context->getI18N()->__('No' ,null,'workflowmanagement');
                                return $result;
                                break;
                            case 'FILE':
                                $value = WorkflowSlotFieldFileTable::instance()->getAllItemsByWorkflowFieldId($fields[0]['id'])->toArray();
                                $url = (url_for('layout/index',true));
                                $url = str_replace('/layout', '', $url);
                                $result['filepath'] = $url . '/file/showAttachment/workflowid/' . $wfItem[0]['workflow_template_id'] . '/versionid/' . $wfItem[0]['id'] . '/attachmentid/' . $value[0]['id'] . '/file/1';
                                $fileUrl = '<a href="'.$result['filepath'].'">'.$value[0]['filename'].'</a>';
                                return $fileUrl;
                                break;

                        }
                    }
                    else {
                        return '';
                    }
                }
            }
        }
    }



    public function getProcess($version_id) {
        $slots = WorkflowSlotTable::instance()->getSlotByVersionId($version_id);
        $alreadyCompleted = 0;
        $toComplete = 0;
        foreach($slots as $slot) {
            $users = WorkflowSlotUserTable::instance()->getUserBySlotId($slot->getId());
            $toComplete += count($users);
            foreach($users as $user) {
                $processUser = WorkflowProcessUserTable::instance()->getProcessUserByWorkflowSlotUserId($user->getId())->toArray();
                if(!empty($processUser)) {
                    $waiting = true;
                    foreach($processUser as $process) {
                        if(count($processUser) == 1 AND $process['decission_state'] != 'WAITING') {
                            $alreadyCompleted++;
                        }
                        else {
                            if($process['decission_state'] != 'WAITING') {
                                $waiting = false;
                            }
                            else {
                                $waiting = true;
                            }
                        }
                    }
                    if(count($processUser) > 1 AND $waiting == false) {
                        $alreadyCompleted++;
                    }
                }
            }
        }
        $percentDone = ($toComplete/$toComplete);
        $fullPercentDone = 100 / $toComplete;
        $percentDone = $fullPercentDone * $alreadyCompleted;
        if($percentDone > 100) {
            $percentDone = 100;
        }
        $color = '';
        if($percentDone < 15) {

        }
        else if ($percentDone >= 15 AND $percentDone < 30) {
            $color = '#FF0000';
        }
        else if ($percentDone >= 30 AND $percentDone < 45) {
            $color = '#FF9933';
        }
        else if ($percentDone >= 45 AND $percentDone < 60) {
            $color = '#FFCC33';
        }
        else if ($percentDone >= 60 AND $percentDone < 75) {
            $color = '#FFFF33';
        }
        else if ($percentDone >= 75 AND $percentDone < 90) {
            $color = '#99FF99';
        }
        else {
            $color = '#00FF00';
        }
        return '<div style="background-color:'.$color.'; width:'.$percentDone.'px;">'.floor($percentDone) . ' %'.'</div>';
    }


    public function getCurrentStation($active_version_id, $sender_id) {
        $result = array();
        $activeVersion = WorkflowProcessTable::instance()->getCurrentStation($active_version_id);
        $user = $activeVersion[0]->getWorkflowProcessUser()->toArray();
        $workflowslot = $activeVersion[0]->getWorkflowSlot()->toArray();
        if(!empty($workflowslot)) {
            $slot = DocumentTemplateSlotTable::instance()->getSlotById($workflowslot[0]['slot_id'])->toArray();
            $currentStation = $slot[0]['name'];
            $userdata = UserLoginTable::instance()->findActiveUserById($user['user_id'])->toArray();
            $username = $userdata[0]['username'];
            $currentStation .= ' <i>(' . $username . ')</i>';
            $result[0] = $currentStation;
            $result[1] = $workflowslot[0]['updated_at'];
            return $result;
        }

        return $result;
    }






}
?>