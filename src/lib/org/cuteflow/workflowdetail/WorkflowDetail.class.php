<?php

class WorkflowDetail {


    private $culture;
    private $user;
    private $context;
    public $serverUrl;

    public function  __construct($loadHelper = true) {
        if($loadHelper == true) {
            $this->loadHelper();
            $this->setServerUrl(url_for('layout/index',true));
        }
    }

    public function loadHelper() {
        sfLoader::loadHelpers('Date');
        sfLoader::loadHelpers('CalculateDate');
        sfLoader::loadHelpers('ColorBuilder');
        sfLoader::loadHelpers('I18N');
        sfLoader::loadHelpers('Url');
        sfLoader::loadHelpers('Icon');
    }

    
    public function setContext (sfContext $context_in) {
        $this->context = $context_in;
    }

    public function setCulture($culture_in) {
        $this->culture = $culture_in;
    }

    public function setUser(myUser $user_in) {
        $this->user = $user_in;
    }


    public function setServerUrl($url) {
        $url = str_replace('/layout', '', $url);
        $this->serverUrl = $url;
    }

    /**
     *
     * @param Doctrine_Collection $data
     * @return array $data
     */
    public function buildHeadLine(Doctrine_Collection $data) {
        $result = array();
        $workflowtemplate = WorkflowTemplateTable::instance()->getWorkflowTemplateById($data[0]->getWorkflowtemplateId());
        $mailinglist = $workflowtemplate[0]->getMailinglistVersion()->toArray();
        $mailinglist = MailinglistTemplateTable::instance()->getMailinglistActiveById($mailinglist[0]['mailinglisttemplate_id'])->toArray();
        
        $workflowtemplate = $workflowtemplate->toArray();
        $user = UserLoginTable::instance()->findActiveUserById($workflowtemplate[0]['sender_id']);
        $userdata = $user[0]->getUserData();
        
        $result['workflow'] = $workflowtemplate[0]['name'];
        $result['versionid'] = $data[0]->getId();
        $result['mailinglist'] = $mailinglist[0]['name'];
        $result['mailinglist_id'] = $workflowtemplate[0]['id'];
        $result['workflowtemplateid'] = $data[0]->getWorkflowtemplateId();
        
        $textReplace = new ReplaceTags($data[0]->getId(), $data[0]->getContent(), $this->culture, $this->context);
        $newText = $textReplace->getText();
        $result['content'] = $newText;
        $result['created_at'] = format_date($data[0]->getCreatedAt(), 'g', $this->culture);
        $result['sender_id'] = $workflowtemplate[0]['sender_id'];
        $result['sender'] = $userdata->getFirstname() . ' ' . $userdata->getLastname() . ' <i>('.$user[0]->getUsername().')</i>';
        $result['version'] = $this->getVersion($data[0]->getWorkflowtemplateId());
        return $result;
    }

    public function getVersion($workflowtemplate_id) {
        $allVersions = WorkflowVersionTable::instance()->getAllVersionRevisionByWorkflowId($workflowtemplate_id);
        $result = array();
        $a = 0;
        $counter = count($allVersions);
        foreach($allVersions as $version) {
            $result[$a]['versionid'] = $version->getId();
            $result[$a]['version'] = $version->getVersion();
            $result[$a]['activeversion'] = $version->getActiveversion();
            $result[$a++]['text'] = '#' . $counter . ' - ' . format_date($version->getCreatedAt(), 'g', $this->culture);
            $counter--;
        }
        return $result;
    }







    public function buildUserData(Doctrine_Collection $data, $templateversion_id) {
        $result = array();
        $returnData = array();
        $a = 0;
        $slots = WorkflowSlotTable::instance()->getSlotByVersionId($data[0]->getId());

        $workflowVersion = WorkflowTemplateTable::instance()->getWorkflowTemplateByVersionId($templateversion_id);
        $template = MailinglistVersionTable::instance()->getSingleVersionById($workflowVersion[0]->getMailinglisttemplateversionId())->toArray();

        foreach($slots as $slot) {
            $documenttemplateslot = $slot->getDocumenttemplateSlot()->toArray();
            $result[$a]['slotname'] = $documenttemplateslot[0]['name'];
            $result[$a]['senttoallatonce'] = $template[0]['sendtoallslotsatonce'];
            $result[$a]['workflowslot_id'] = $slot->getId();
            $result[$a]['sendtoallreceivers'] = $documenttemplateslot[0]['sendtoallreceivers'];
            $result[$a]['slot_id'] = $documenttemplateslot[0]['id'];
            $result[$a++]['user'] = $this->getUser($slot->getId(), $data[0]->getWorkflowtemplateId(), $documenttemplateslot[0]['name'], $a, $templateversion_id);
        }
        $returnData = $this->mergeArray($result);
        return $returnData;
    }


    public function getUser($slot_id, $workflowtemplate_id, $slotname, $slotcounter, $templateversion_id) {
        $users = WorkflowSlotUserTable::instance()->getUserBySlotId($slot_id);
        $result = array();
        $a = 0;
        foreach($users as $user) {
            $userlogin = array();
            $userlogin = $user->getUserLogin()->toArray();
            $userData = UserDataTable::instance()->getUserDataByUserId($userlogin[0]['id'])->toArray();
            $result[$a]['user_id'] = $user->getUserId();
            $result[$a]['id'] = $user->getId();
            $result[$a]['plainusername'] = $userData[0]['firstname'] . ' '  . $userData[0]['lastname'] . ' <i>('.$userlogin[0]['username'].')</i>';
            $result[$a]['username'] = '<table><tr><td width="16"><img src="/images/icons/user.png" /></td><td>' . $userlogin[0]['username'] . '</td></tr></table>';
            $result[$a]['slotgroup'] = '#' . $slotcounter . ' : ' . $slotname;
            $result[$a]['templateversion_id'] = $templateversion_id;
            $result[$a]['user'] = $this->getDecission($user, $templateversion_id);
            $a++;
        }
        return $result;
    }




    public function getDecission (WorkflowSlotUser $user, $templateversion_id) {
        $result = array();
        $a = 0;
        $processUsers = WorkflowProcessUserTable::instance()->getProcessUserByWorkflowSlotUserId($user->getId());
        foreach($processUsers as $processUser) {
            $result[$a] = $processUser->toArray();
            $result[$a]['received'] = format_date($result[$a]['inprogresssince'], 'g', $this->culture);
            $result[$a]['decission_id'] = $result[$a]['id'];
            $result[$a]['endreasion'] = '';
            $result[$a]['useragent_id'] = $result[$a]['user_id'];
            $result[$a]['isuseragentof'] = $result[$a]['isuseragentof'];
            $usersettings = $this->user->getAttribute('userSettings');
            $inProgress = createDayOutOfDateSince(date('Y-m-d', $result[$a]['inprogresssince']));
            $inProgress = addColor($inProgress, $usersettings['markred'],$usersettings['markorange'],$usersettings['markyellow']);
            $result[$a]['inprogresssince'] = '<table><tr><td width="20">' . $inProgress . ' </td><td>' . $this->context->getI18N()->__('Days' ,null,'workflowmanagement') . '</td></tr></table>';
            $result[$a]['decissioninwords'] = '<table><tr><td>'.AddStateIcon($result[$a]['decissionstate']).'</td><td>' . $this->context->getI18N()->__($result[$a]['decissionstate'],null,'workflowmanagement') . '</td></tr></table>';
            if($result[$a]['decissionstate'] == 'STOPPEDBYADMIN') {
                $result[$a]['inprogresssince'] = '-';
            }
            elseif($result[$a]['decissionstate'] == 'STOPPEDBYUSER') {
                $endReasion = WorkflowVersionTable::instance()->getWorkflowVersionById($templateversion_id);
                $result[$a]['endreasion'] = $endReasion[0]->getEndreason();
            }
            $a++;
        }
        return $result;
    }



    public function mergeArray(array $data) {
        $result = array();
        $slotcounter = 0;
        $userdata = array();
        $usercounter = 0;
        for($a=0;$a<count($data);$a++) {
            $result[$a]['slotname'] = $data[$a]['slotname'];
            $result[$a]['workflowslot_id'] = $data[$a]['workflowslot_id'];
            $result[$a]['sendtoallreceivers'] = $data[$a]['sendtoallreceivers'];
            $result[$a]['senttoallatonce'] = $data[$a]['senttoallatonce'];
            $result[$a]['slot_id'] = $data[$a]['slot_id'];
            for($b=0;$b<count($data[$a]['user']);$b++) {
                $userData = $data[$a]['user'][$b];

                if(isset($userData['user'][0]) == true) {
                    for($d=0;$d<count($userData['user']);$d++) {
                        $decission = $userData['user'][$d];

                        $result[$a]['user'][$usercounter]['user_id'] = $userData['user_id'];
                        $result[$a]['user'][$usercounter]['id'] = $userData['id'];
                        $result[$a]['user'][$usercounter]['username'] = $userData['username'];
                        $result[$a]['user'][$usercounter]['plainusername'] = $userData['plainusername'];
                        $result[$a]['user'][$usercounter]['slotgroup'] = $userData['slotgroup'];
                        $result[$a]['user'][$usercounter]['templateversion_id'] = $userData['templateversion_id'];

                        $result[$a]['user'][$usercounter]['useragent_id'] = $decission['useragent_id'];
                        $result[$a]['user'][$usercounter]['isuseragentof'] = $decission['isuseragentof'];
                        $result[$a]['user'][$usercounter]['workflowprocess_id'] = $decission['workflowprocess_id'];
                        $result[$a]['user'][$usercounter]['workflowslotuser_id'] = $decission['workflowslotuser_id'];
                        $result[$a]['user'][$usercounter]['inprogresssince'] = $decission['inprogresssince'];
                        $result[$a]['user'][$usercounter]['decissionstate'] = $decission['decissionstate'];
                        $result[$a]['user'][$usercounter]['dateofdecission'] = $decission['dateofdecission'];
                        $result[$a]['user'][$usercounter]['isuseragentof'] = $decission['isuseragentof'];
                        $result[$a]['user'][$usercounter]['received'] = $decission['received'];
                        $result[$a]['user'][$usercounter]['decission_id'] = $decission['decission_id'];
                        $result[$a]['user'][$usercounter]['endreasion'] = $decission['endreasion'];
                        $result[$a]['user'][$usercounter]['decissioninwords'] = $decission['decissioninwords'];
                        if($result[$a]['user'][$usercounter]['isuseragentof'] != '') {
                            $userAgent = UserLoginTable::instance()->findActiveUserById($result[$a]['user'][$usercounter]['useragent_id'])->toArray();
                            $result[$a]['user'][$usercounter]['username'] = '<table><tr><td width="16">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="/images/icons/user_go.png" /></td><td>' . $userAgent[0]['username'] . '</td></tr></table>';
                        }
                        $usercounter++;
                    }
                }
                else {
                    $result[$a]['user'][$usercounter]['user_id'] = $userData['user_id'];
                    $result[$a]['user'][$usercounter]['id'] = $userData['id'];
                    $result[$a]['user'][$usercounter]['username'] = $userData['username'];
                    $result[$a]['user'][$usercounter]['plainusername'] = $userData['plainusername'];
                    $result[$a]['user'][$usercounter]['slotgroup'] = $userData['slotgroup'];
                    $result[$a]['user'][$usercounter]['templateversion_id'] = $userData['templateversion_id'];

                    $result[$a]['user'][$usercounter]['useragent_id'] = '';
                    $result[$a]['user'][$usercounter]['isuseragentof'] = '';
                    $result[$a]['user'][$usercounter]['workflowprocess_id'] = '';
                    $result[$a]['user'][$usercounter]['workflowslotuser_id'] = '';
                    $result[$a]['user'][$usercounter]['inprogresssince'] = '';
                    $result[$a]['user'][$usercounter]['decissionstate'] = '';
                    $result[$a]['user'][$usercounter]['dateofdecission'] = '';
                    $result[$a]['user'][$usercounter]['isuseragentof'] = '';
                    $result[$a]['user'][$usercounter]['received'] = '';
                    $result[$a]['user'][$usercounter]['decission_id'] = '';
                    $result[$a]['user'][$usercounter]['endreasion'] = '';
                    $result[$a]['user'][$usercounter]['decissioninwords'] = '';
                    $usercounter++;
                }
            }
            $usercounter = 0;

        }
       # print_r ($result);die;
        return $result;
    }



    public function buildWorkflowData(Doctrine_Collection $data, $versionid) {
        $slots = WorkflowSlotTable::instance()->getSlotByVersionId($versionid);
        $result = array();
        $a = 0;
        foreach($slots as $slot) {
            $slotArray = $slot->toArray();
            $result[$a]['workflowslot_id'] = $slotArray['id'];
            $result[$a]['slot_id'] = $slotArray['slot_id'];
            $result[$a]['position'] = $slotArray['position'];
            $result[$a]['slotname'] = $slotArray['DocumenttemplateSlot'][0]['name'];
            $result[$a++]['fields'] = $this->getFields($slotArray['id'], $versionid);
        }
        #print_r ($result);die;
        return $result;
    }



    public function getFields($id, $versionid) {
        $result = array();
        $a = 0;
        $fields = WorkflowSlotFieldTable::instance()->getWorkflowSlotFieldBySlotId($id);
        $column = 'LEFT';
        foreach($fields as $field) {
            $documentField = $field->getField()->toArray();
            $result[$a]['workflowslotfield_id'] = $field->getId();
            $result[$a]['workflowslot_id'] = $field->getWorkflowslotId();
            $result[$a]['field_id'] = $field->getFieldId();
            $result[$a]['title'] = $documentField[0]['title'];
            $result[$a]['type'] = $documentField[0]['type'];
            if($column == 'LEFT') {
                $column = 'RIGHT';
                $result[$a]['column'] = 'LEFT';
            }
            else {
                $column = 'LEFT';
                $result[$a]['column'] = 'RIGHT';
            }
            $result[$a]['position'] = $field->getPosition();
            $result[$a++]['items'] = $this->getFieldItems($field, $documentField[0]['type'], $this->context, $versionid);


        }
        return $result;

    }


    public function getFieldItems(WorkflowSlotField $field, $type, sfContext $context, $versionid) {
        $result = array();
        $a = 0;
        switch ($type) {
            case 'TEXTFIELD':
                $items = WorkflowSlotFieldTextfieldTable::instance()->getAllItemsByWorkflowFieldId($field->getId())->toArray();
                $fieldData = FieldTextfieldTable::instance()->getTextfieldByFieldId($field->getFieldId())->toArray();
                $replaceObj = new ReplaceTags($versionid, $items[0]['value'], $this->culture, $context);
                $value = $replaceObj->getText();
                $result['value'] = $value;
                $result['regex'] = $fieldData[0]['regex'];
                $result['id'] = $items[0]['id'];
                break;
            case 'CHECKBOX':
                $items = WorkflowSlotFieldCheckboxTable::instance()->getAllItemsByWorkflowFieldId($field->getId())->toArray();
                $result['value'] = $items[0]['value'];
                $result['id'] = $items[0]['id'];
                break;
            case 'NUMBER':
                $items = WorkflowSlotFieldNumberTable::instance()->getAllItemsByWorkflowFieldId($field->getId())->toArray();
                $fieldData = FieldNumberTable::instance()->getNumberByFieldId($field->getFieldId())->toArray();
                if($fieldData[0]['comboboxvalue'] != 'EMPTY') {
                    $result['emptytext'] = $context->getI18N()->__($fieldData[0]['comboboxvalue'] ,null,'field');
                }
                else {
                    $result['emptytext'] = $fieldData[0]['regex'];
                }
                $result['value'] = $items[0]['value'];
                $result['regex'] = $fieldData[0]['regex'];
                $result['id'] = $items[0]['id'];
                break;
            case 'DATE':
                $items = WorkflowSlotFieldDateTable::instance()->getAllItemsByWorkflowFieldId($field->getId())->toArray();
                $format = FieldDateTable::instance()->getDateByFieldId($field->getFieldId())->toArray();
                $result['value'] = $items[0]['value'];
                $result['dateformat'] = $format[0]['dateformat'];
                $result['regex'] = $format[0]['regex'];
                $result['id'] = $items[0]['id'];
                break;
            case 'TEXTAREA':
                $items = WorkflowSlotFieldTextareaTable::instance()->getAllItemsByWorkflowFieldId($field->getId())->toArray();
                $textarea = FieldTextareaTable::instance()->getTextareaById($field->getFieldId())->toArray();
                $result['value'] = $items[0]['value'];
                $result['contenttype'] = $textarea[0]['contenttype'];
                $result['id'] = $items[0]['id'];
                break;
            case 'RADIOGROUP':
                $items = WorkflowSlotFieldRadiogroupTable::instance()->getAllItemsByWorkflowFieldId($field->getId());
                foreach($items as $item) {
                    $name = FieldRadiogroupTable::instance()->getRadiogroupItemById($item->getFieldradiogroupId())->toArray();
                    $result[$a]['value'] = $item->getValue();
                    $result[$a]['id'] = $item->getId();
                    $result[$a++]['name'] = $name[0]['value'];
                }
                break;
            case 'CHECKBOXGROUP':
                $items = WorkflowSlotFieldCheckboxgroupTable::instance()->getAllItemsByWorkflowFieldId($field->getId());
                foreach($items as $item) {
                    $name = FieldCheckboxgroupTable::instance()->getCheckboxgroupItemById($item->getFieldcheckboxgroupId())->toArray();
                    $result[$a]['value'] = $item->getValue();
                    $result[$a]['id'] = $item->getId();
                    $result[$a++]['name'] = $name[0]['value'];
                }
                break;
            case 'COMBOBOX':
                $items = WorkflowSlotFieldComboboxTable::instance()->getAllItemsByWorkflowFieldId($field->getId());
                foreach($items as $item) {
                    $name = FieldComboboxTable::instance()->getComboboxItemById($item->getFieldcomboboxId())->toArray();
                    $result[$a]['value'] = $item->getValue();
                    $result[$a]['id'] = $item->getId();
                    $result[$a++]['name'] = $name[0]['value'];
                }
                break;
            case 'FILE':

                $file = WorkflowSlotFieldFileTable::instance()->getAllItemsByWorkflowFieldId($field->getId())->toArray();
                $workflowtemplate = WorkflowVersionTable::instance()->getWorkflowVersionById($versionid)->toArray();
                $result['filepath'] = sfConfig::get('sf_upload_dir') . '/' . $workflowtemplate[0]['workflowtemplate_id'] . '/' . $versionid . '/' . $file[0]['hashname'] ;
                $result['hashname'] = $file[0]['hashname'];
                $result['filename'] = $file[0]['filename'];
                $url = $this->serverUrl . '/file/ShowAttachment';
                $plainUrl = $this->serverUrl . '/file/ShowAttachment';
                $url .= '/workflowid/' .  $workflowtemplate[0]['workflowtemplate_id'] . '/versionid/' . $versionid. '/attachmentid/' . $file[0]['id'] . '/file/1';
                $plainUrl .= '/workflowid/' .  $workflowtemplate[0]['workflowtemplate_id'] . '/versionid/' . $versionid. '/attachmentid/' . $file[0]['id'] . '/file/1';
                $result['plainurl'] = $plainUrl;
                $result['url'] = $url;
                $result['link'] = '<a href="'.$url.'" target="_blank">'.$result['filename'].'</a>';
                break;
        }
        return $result;
    }

    public function buildAttachments(Doctrine_Collection $data, $templateversion_id) {
        $files = WorkflowVersionAttachmentTable::instance()->getAttachmentsByVersionId($templateversion_id)->toArray();
        $result = array();
        $a = 0;
        foreach($files as $file) {
            $result[$a]['filepath'] = sfConfig::get('sf_upload_dir') . '/' . $file['workflowtemplate_id'] . '/' . $file['workflowversion_id'] . '/' . $file['hashname'] ;
            $result[$a]['hashname'] = $file['hashname'];
            $result[$a]['filename'] = $file['filename'];
            $url = $this->serverUrl . '/file/ShowAttachment';
            $url .= '/workflowid/' .  $file['workflowtemplate_id'] . '/versionid/' . $file['workflowversion_id'] . '/attachmentid/' . $file['id'] . '/file/0';
            $result[$a]['link'] = '<a href="'.$url.'" target="_blank">'.$result[$a]['filename'].'</a>';
            $a++;
        }
        
        return $result;
    }



























}
?>