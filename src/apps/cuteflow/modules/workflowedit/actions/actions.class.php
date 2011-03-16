<?php

/**
 * workflowedit actions.
 *
 * @package    cf
 * @subpackage workflowedit
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class workfloweditActions extends sfActions {




    /**
     * Load all data, wich is needed to fill out an workflow
     * generalData like sender, creation date is loaded
     * slotData, all slots to fill out
     * workflowAttachment, load public attachments
     * userData: tree on left side, to show current process
     * showName: flag if users can be shown in the left side or not
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadWorkflowData(sfWebRequest $request) {
        sfLoader::loadHelpers('EndAction');
        $detailsObj = new WorkflowDetail();
        $detailsObj->setUser($this->getUser());
        $detailsObj->setCulture($this->getUser()->getCulture());
        $detailsObj->setContext($this->getContext());
        $workflowsettings = WorkflowVersionTable::instance()->getWorkflowVersionById($request->getParameter('versionid'));
        $generalData = $detailsObj->buildHeadLine($workflowsettings);
        $attachments = $detailsObj->buildAttachments($workflowsettings, $request->getParameter('versionid'));
        $userData = $detailsObj->buildUserData($workflowsettings, $request->getParameter('versionid'));
        $workflowDecission = WorkflowTemplateTable::instance()->getWorkflowTemplateById($workflowsettings[0]->getWorkflowtemplateId())->toArray();        
        $endAction = getEndAction($workflowDecission[0]['endaction']);

        $slotObj = new WorkflowEdit();
        $slotObj->setUser($this->getUser());
        $slotObj->setCulture($this->getUser()->getCulture());
        $slotObj->setContext($this->getContext());
        $slotData = $slotObj->buildSlots($workflowsettings, $request->getParameter('versionid'));
        
        $this->renderText('{"generalData":'.json_encode($generalData).',"slotData":'.json_encode($slotData).', "workflowAttachment" : '.json_encode($attachments).', "userData" : '.json_encode($userData).',"showName": '.$endAction[0].'}');
        return sfView::NONE;
    }


    /**
     * Function allows to save an workflow out of an email (IFRAME)
     * 
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeSaveIFrame (sfWebRequest $request) {
        sfLoader::loadHelpers('Url');
        $failure = array();
        $workflowSaveObj = new SaveWorkflow();
        $data = $request->getPostParameters();
        // data mus be set
        if(!empty($data)) {
            // check if all fields are correct set
            $failure = $workflowSaveObj->checkFields($data['field']);
            if($failure['isFalse'] == 0) {
                 // workflow accepted
                if($data['workfloweditAcceptWorkflow_decission'] == 1) {
                    if(isset($data['field'])) {
                        foreach($data['field'] as $field) {
                            switch ($field['type']) {
                                case 'TEXTFIELD':
                                    WorkflowSlotFieldTextfieldTable::instance()->updateTextfieldById($field['field_id'],$field['value']);
                                    break;
                                case 'CHECKBOX':
                                    $value = isset($field['value']) == true ? 1 : 0;
                                    WorkflowSlotFieldCheckboxTable::instance()->updateCheckboxById($field['field_id'],$value);
                                    break;
                                case 'NUMBER':
                                    WorkflowSlotFieldNumberTable::instance()->updateNumberById($field['field_id'],$field['value']);
                                    break;
                                case 'DATE':
                                    WorkflowSlotFieldDateTable::instance()->updateDateById($field['field_id'],$field['value']);
                                    break;
                                case 'TEXTAREA':
                                    WorkflowSlotFieldTextareaTable::instance()->updateTextareaById($field['field_id'],$field['value']);
                                    break;
                                case 'RADIOGROUP':
                                    $radioGroupId = WorkflowSlotFieldRadiogroupTable::instance()->getRadiogroupById($field['field_id'])->toArray();
                                    WorkflowSlotFieldRadiogroupTable::instance()->setToNullByFieldId($radioGroupId[0]['workflowslotfield_id']);
                                    if(isset($field['id'])) {
                                        WorkflowSlotFieldRadiogroupTable::instance()->updateRadiogroupById($field['id'],1);
                                    }
                                    break;
                                case 'CHECKBOXGROUP':
                                    $checkGroupId = WorkflowSlotFieldCheckboxgroupTable::instance()->getCheckboxgroupById($field['field_id'])->toArray();
                                    WorkflowSlotFieldCheckboxgroupTable::instance()->setToNullByFieldId($checkGroupId[0]['workflowslotfield_id']);
                                    if(isset($field['items']) == true) {
                                        foreach($field['items'] as $singleItem) {
                                            WorkflowSlotFieldCheckboxgroupTable::instance()->updateCheckboxgroupById($singleItem['id'],1);
                                        }
                                    }
                                    break;
                                case 'COMBOBOX':
                                    if($field['id'] != '') {
                                        $comboboxGroupId = WorkflowSlotFieldComboboxTable::instance()->getComboboxById($field['id'])->toArray();
                                        WorkflowSlotFieldComboboxTable::instance()->setToNullByFieldId($comboboxGroupId[0]['workflowslotfield_id']);
                                        WorkflowSlotFieldComboboxTable::instance()->updateComboboxById($field['id'],1);
                                    }
                                    break;
                                case 'FILE':
                                    break;
                                }

                        }
                    }
                    // calculate next station
                    $slots = $data['slot'];
                    $context = sfContext::getInstance();
                    $context->getConfiguration()->loadHelpers('Partial', 'I18N', 'Url', 'Date', 'CalculateDate', 'ColorBuilder', 'Icon', 'EndAction');
                    $workflowSaveObj->setContext($context);
                    $workflowSaveObj->setServerUrl(str_replace('/layout', '', url_for('layout/index',true)));
                    $workflowSaveObj->getNextStation($slots,$request->getParameter('userid'),$request->getParameter('versionid'));
                }
                // deny workflow
                else {
                    $workflowSaveObj->denyWorkflow($data, $request->getParameter('workflowid'), $request->getParameter('userid'), $request->getParameter('versionid'));
                }
                $this->setLayout(false);
                $this->setTemplate('writing');
                return sfView::SUCCESS;
            }
            else {
                return $this->redirect($this->generateUrl('default', array('module' => 'iframe', 'action' => 'getIFrame', 'userid' => $request->getParameter('userid'), 'workflowid' => $request->getParameter('workflowid'), 'versionid' => $request->getParameter('versionid'), 'error' => 1)));
            }
        }
        else {
                // workflow not correct
               $this->setLayout(false);
               $this->setTemplate('failure');
               return sfView::SUCCESS;
        }
        return sfView::NONE;
    }





    /**
     * Save workflow out of the browser
     * 
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeSaveWorkflow(sfWebRequest $request) {
        sfLoader::loadHelpers('Url');
        $data = $request->getPostParameters();
        $workflowSaveObj = new SaveWorkflow();
        if($data['workfloweditAcceptWorkflow_decission'] == 1) { // user accepted Workflow
            // workflow contains fields to write, not e.g. not only file-fields
            if(isset($data['field'])) {
                foreach($data['field'] as $field) {
                    switch ($field['type']) {
                    case 'TEXTFIELD':
                        WorkflowSlotFieldTextfieldTable::instance()->updateTextfieldByWorkflowFieldId($field['field_id'],$field['value']);
                        break;
                    case 'CHECKBOX':
                        $value = $field['value'] == 'false' ? 0 : 1;
                        WorkflowSlotFieldCheckboxTable::instance()->updateCheckboxByWorkflowFieldId($field['field_id'],$value);
                        break;
                    case 'NUMBER':
                        WorkflowSlotFieldNumberTable::instance()->updateNumberByWorkflowFieldId($field['field_id'],$field['value']);
                        break;
                    case 'DATE':
                        WorkflowSlotFieldDateTable::instance()->updateDateByWorkflowFieldId($field['field_id'],$field['value']);
                        break;
                    case 'TEXTAREA':
                        WorkflowSlotFieldTextareaTable::instance()->updateTextareaByWorkflowFieldId($field['field_id'],$field['value']);
                        break;
                    case 'RADIOGROUP':
                        $items = $field['item'];
                        foreach($items as $item) {
                            $value = $item['value'] == 'false' ? 0 : 1;
                            WorkflowSlotFieldRadiogroupTable::instance()->updateRadiogroupById($item['id'],$value);
                        }
                        break;
                    case 'CHECKBOXGROUP':
                        $items = $field['item'];
                        foreach($items as $item) {
                            $value = $item['value'] == 'false' ? 0 : 1;
                            WorkflowSlotFieldCheckboxgroupTable::instance()->updateCheckboxgroupById($item['id'],$value);
                        }
                        break;
                    case 'COMBOBOX':
                        $items = $field['item'];
                        foreach($items as $item) {
                            $value = $item['value'] == 'false' ? 0 : 1;
                            WorkflowSlotFieldComboboxTable::instance()->updateComboboxById($item['id'],$value);
                        }
                        break;
                    case 'FILE':
                        break;
                    }
                }
            }
            // calculate next station
            $context = sfContext::getInstance();
            $context->getConfiguration()->loadHelpers('Partial', 'I18N', 'Url', 'Date', 'CalculateDate', 'ColorBuilder', 'Icon', 'EndAction');
            $slots = $data['slot'];
            $workflowSaveObj->setContext($context);
            $workflowSaveObj->setServerUrl(str_replace('/layout', '', url_for('layout/index',true)));
            $workflowSaveObj->getNextStation($slots,$this->getUser()->getAttribute('id'),$request->getParameter('versionid'));
        }
        else { // user denies workflow
            $workflowSaveObj->denyWorkflow($data, $request->getParameter('workflowid'), $this->getUser()->getAttribute('id'), $request->getParameter('versionid'));
        }
        $this->renderText('{success:true}');
        return sfView::NONE;
    }

    









}
