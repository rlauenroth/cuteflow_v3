<?php

/**
 * restartworkflow actions.
 *
 * @package    cf
 * @subpackage restartworkflow
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class restartworkflowActions extends sfActions {

    /**
     * Load All Stations for a workflow, to select one where the workflow will restart
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadAllStation(sfWebRequest $request) {
        $workObj = new RestartWorkflow();
        $data = WorkflowSlotTable::instance()->getSlotByVersionId($request->getParameter('versionid'));
        $json_data = $workObj->buildSelectStation($data);
        $workflowSendSlot = $workObj->getSendToAllSlots($request->getParameter('versionid'));
        $this->renderText('{"result" : ' . json_encode($json_data) . ', "sendtoallslots" : ' . $workflowSendSlot . '}');
        return sfView::NONE;
    }

    /**
     * the Action restarts the workflow
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeRestartWorkflow(sfWebRequest $request) {

        require_once sfConfig::get('sf_root_dir') . '/lib/vendor/symfony/helper/UrlHelper.php';

        $context = sfContext::getInstance();
        $context->getConfiguration()->loadHelpers('Partial', 'I18N', 'Url', 'Date', 'CalculateDate', 'ColorBuilder', 'Icon', 'EndAction');
        $createWorkObj = new PrepareWorkflowData();
        $startDate = array();

        $version_id = $request->getParameter('versionid');
        $newValue = $request->getParameter('restartWorkflowFirstTab_useoldvalues', 0); // set flag if values form previous version will be used or from the default value of the fields
        $endreason = $createWorkObj->createEndreason($request->getPostParameter('restartWorkflowFirstTabSettings', array())); // set additional settings
        $startDate = $createWorkObj->createStartDate('', ''); // startdate is always at the moment
        $content = $createWorkObj->createRestartContenttype($request->getPostParameters()); // ste contenttype of the additional text

        $workflow_template_id = WorkflowVersionTable::instance()->getWorkflowVersionById($version_id)->toArray(); // load the current workflowversion


        WorkflowTemplateTable::instance()->updateEndAction($workflow_template_id[0]['id'], $endreason); // update the endaction/additionalsettings


        $currentVersion = WorkflowVersionTable::instance()->getLastVersionById($workflow_template_id[0]['workflow_template_id'])->toArray(); // load the last workflow
        $slots = WorkflowSlotTable::instance()->getSlotByVersionId($version_id); // get all slots for the current workflow


        WorkflowVersionTable::instance()->setVersionInactive($version_id); // set the current version inactive
        WorkflowTemplateTable::instance()->restartWorkflow($workflow_template_id[0]['workflow_template_id']); // remove stopflag from template


        $wfRestart = new RestartWorkflow();
        // set flag if workflow uses old values or not
        $wfRestart->setNewValue($newValue);

        //load the data for fields. they contain old values or the default field values. the data array contains slots and its fields, values and users of the last version
        $data = $wfRestart->buildSaveData($slots);

        // create a new instance of the workflow
        $wfVersion = new WorkflowVersion();
        $wfVersion->setWorkflowTemplateId($workflow_template_id[0]['workflow_template_id']);
        $wfVersion->setActiveVersion(1);
        $wfVersion->setContent($content['content']);
        $wfVersion->setStartWorkflowAt($startDate['start_workflow_at']);
        $wfVersion->setContentType($content['content_type']);
        $wfVersion->setWorkflowIsStarted($startDate['workflow_is_started']);
        $wfVersion->setVersion($currentVersion[0]['version'] + 1);
        $wfVersion->save();
        $newVersionId = $wfVersion->getId();

        /*
         * to transfer the last version of the workflow into a new one, it is needed to copy
         * the old version and set new relations (ids). $slotCounter stores the id's of the
         * new created slots, user and userproeccess, to replace the old values with the new ones.
         */
        $dataStore = array();
        $slotCounter = 0;

        foreach ($data as $slot) {

            $singleSlot = new WorkflowSlot();
            $singleSlot->setWorkflowVersionId($newVersionId);
            $singleSlot->setSlotId($slot['slot_id']);
            $singleSlot->setPosition($slot['position']);
            $singleSlot->save();

            $slotId = $singleSlot->getId();
            // ids of created slots
            $dataStore[$slotCounter]['slot_id'] = $slotId;

            $fields = $slot['fields']; // the fields of the slot
            $users = $slot['users']; // the users of the slot
            // create the fields for the slot and set the value
            foreach ($fields as $field) {
                $newField = new WorkflowSlotField();
                $newField->setWorkflowSlotId($slotId);
                $newField->setFieldId($field['field_id']);
                $newField->setPosition($field['position']);
                $newField->save();
                $fieldId = $newField->getId();
                switch ($field['type']) {
                    case 'TEXTFIELD':
                        $newField = new WorkflowSlotFieldTextfield();
                        $newField->setWorkflowSlotFieldId($fieldId);
                        $newField->setValue($field['items'][0]['value']);
                        $newField->save();
                        break;
                    case 'CHECKBOX':
                        $newField = new WorkflowSlotFieldCheckbox();
                        $newField->setWorkflowSlotFieldId($fieldId);
                        $newField->setValue($field['items'][0]['value']);
                        $newField->save();
                        break;
                    case 'NUMBER':
                        $newField = new WorkflowSlotFieldNumber();
                        $newField->setWorkflowSlotFieldId($fieldId);
                        $newField->setValue($field['items'][0]['value']);
                        $newField->save();
                        break;
                    case 'DATE':
                        $newField = new WorkflowSlotFieldDate();
                        $newField->setWorkflowSlotFieldId($fieldId);
                        $newField->setValue($field['items'][0]['value']);
                        $newField->save();
                        break;
                    case 'TEXTAREA':
                        $newField = new WorkflowSlotFieldTextarea();
                        $newField->setWorkflowSlotFieldId($fieldId);
                        $newField->setValue($field['items'][0]['value']);
                        $newField->save();
                        break;
                    case 'RADIOGROUP':
                        $items = $field['items'];
                        foreach ($items as $item) {
                            $newField = new WorkflowSlotFieldRadiogroup();
                            $newField->setWorkflowSlotFieldId($fieldId);
                            $newField->setFieldradiogroupId($item['fieldradiogroup_id']);
                            $newField->setValue($item['value']);
                            $newField->setPosition($item['position']);
                            $newField->save();
                        }
                        break;
                    case 'CHECKBOXGROUP':
                        $items = $field['items'];
                        foreach ($items as $item) {
                            $newField = new WorkflowSlotFieldCheckboxgroup();
                            $newField->setWorkflowSlotFieldId($fieldId);
                            $newField->setFieldcheckboxgroupId($item['fieldradiogroup_id']);
                            $newField->setValue($item['value']);
                            $newField->setPosition($item['position']);
                            $newField->save();
                        }
                        break;
                    case 'COMBOBOX':
                        $items = $field['items'];
                        foreach ($items as $item) {
                            $newField = new WorkflowSlotFieldCombobox();
                            $newField->setWorkflowSlotFieldId($fieldId);
                            $newField->setFieldComboboxId($item['fieldradiogroup_id']);
                            $newField->setValue($item['value']);
                            $newField->setPosition($item['position']);
                            $newField->save();
                        }
                        break;
                    case 'FILE':
                        $moveFile = new FileUpload();
                        $moveFile->moveFile($field['items'][0], $newVersionId, $workflow_template_id[0]['workflow_template_id'], $request->getParameter('versionid'));
                        $newField = new WorkflowSlotFieldFile();
                        $newField->setWorkflowSlotFieldId($fieldId);
                        $newField->setFilename($field['items'][0]['filename']);
                        $newField->setHashname($field['items'][0]['hashname']);
                        $newField->save();
                        break;
                }
            }

            // save the users for a slot
            $userCounter = 0;
            foreach ($users as $user) {
                $wfSlotUser = new WorkflowSlotUser();
                $wfSlotUser->setWorkflowSlotId($slotId);
                $wfSlotUser->setPosition($user['position']);
                $wfSlotUser->setUserId($user['user_id']);
                $wfSlotUser->save();
                // store the new id of the user and its user_id
                $dataStore[$slotCounter]['slotuser_id'][$userCounter]['id'] = $wfSlotUser->getId();
                $dataStore[$slotCounter]['slotuser_id'][$userCounter++]['user_id'] = $user['user_id'];
            }
            $slotCounter++;
        }


        /**
         *  save files from file grid in overview.
         *  files are moved forom ext
         *  $keys[0]['uploadfile']->file1
         *  $keys[1]['uploadfile']->file2
         *  it is also necessary to use $_FILES instead of $request->getFiles()
         */
        $files = $_FILES;
        $keys = array();
        $keys = array_keys($files);

        for ($a = 0; $a < count($keys); $a++) {
            $key = $keys[$a];
            if (substr_count($key, 'uploadfile') == 1) {
                $fileUpload = new FileUpload();
                $fileUpload->uploadFile($files[$key], $newVersionId, $workflow_template_id[0]['workflow_template_id']);
            }
        }
        $workflowTemplate = WorkflowTemplateTable::instance()->getWorkflowTemplateByVersionId($version_id)->toArray();


        $sendToAllSlotsAtOnce = MailinglistVersionTable::instance()->getActiveVersionById($workflowTemplate[0]['mailinglist_template_version_id'])->toArray();
        if ($request->getPostParameter('restartWorkflowFirstTab_startpoint') == 'BEGINNING') { // workflow starts from beginning
            // check if mailinglist is send to all slots at once, no workflowprocessuser data is needed to be loaded
            if ($sendToAllSlotsAtOnce[0]['send_to_all_slots_at_once'] == 1) { // create all slots
                $calc = new CreateWorkflow($newVersionId);
                $calc->setServerUrl(str_replace('/layout', '', url_for('layout/index', true)));
                $calc->setContext($context);
                $calc->addAllSlots();
            } else { // create a single slot
                $calc = new CreateWorkflow($newVersionId);
                $calc->setServerUrl(str_replace('/layout', '', url_for('layout/index', true)));
                $calc->setContext($context);
                $calc->addSingleSlot();
            }
        } else if ($request->getPostParameter('restartWorkflowFirstTab_startpoint') == 'LASTSTATION') { // workflow is send to last station
            $wfRestart = new RestartWorkflow();
            $wfRestart->setContext($context);
            $wfRestart->setServerUrl(str_replace('/layout', '', url_for('layout/index', true)));
            // load the workflowprocessuser / workflowprocess data of the old version
            $lastStationdata = $wfRestart->getRestartData($version_id);
            // write the oldversions workflowprocessuser/workflowprocess and set the new id's from $dataStore array
            $wfRestart->restartAtLastStation($lastStationdata, $dataStore, $newVersionId, $workflow_template_id[0]['workflow_template_id']);
        } else { // workflow will start at specific station
            $slotOrder = array();
            $slotOrder = explode('__', $request->getPostParameter('restartWorkflowFirstTab_startpointid'));
            $slotPosition = $slotOrder[1]; // Slot Position worklfow must start
            $userPosition = $slotOrder[3]; // position of the user in the slot. e.g. Slot 3 and User 2
            $currentUserSlotId = $dataStore[0]['slotuser_id'][0]['id']; // get Id of the first WorkflowSlot of the restarted Workflow
            $newUserSlotId = $dataStore[$slotPosition - 1]['slotuser_id'][$userPosition - 1]['id']; // get Id of the first WorkflowSlotUser of the restarted Workflow
            $direction = 'UP'; // direction is UP!
            // write first Process
            $wfProcess = new WorkflowProcess();
            $wfProcess->setWorkflowTemplateId($workflow_template_id[0]['workflow_template_id']);
            $wfProcess->setWorkflowVersionId($newVersionId);
            $wfProcess->setWorkflowSlotId($dataStore[0]['slot_id']);
            $wfProcess->save();
            $wfProcessId = $wfProcess->getId();

            // write first user
            $wfProcessUser = new WorkflowProcessUser();
            $wfProcessUser->setWorkflowProcessId($wfProcessId);
            $wfProcessUser->setWorkflowSlotUserId($dataStore[0]['slotuser_id'][0]['id']);
            $wfProcessUser->setUserId($dataStore[0]['slotuser_id'][0]['user_id']);
            $wfProcessUser->setInProgressSince(time());
            $wfProcessUser->setDecissionState('WAITING');
            $wfProcessUser->setDateOfDecission(time());
            $wfProcessUser->setResendet(0);
            $wfProcessUser->save();
            // use Set Nextstation with direction UP from slot 1 user 1 to defined user e.g. slot 3 and user 2
            $calc = new SetStation($newVersionId, $newUserSlotId, $currentUserSlotId, $direction, $context, str_replace('/layout', '', url_for('layout/index', true)));
        }
        /**
         * set the response of the action.
         * it is needed to use this response when using fileupload in extjs with symfony.
         * extjs is uploading files using iframe. this iframe needs text/html as response
         */
        $this->getResponse()->setHttpHeader('Content-Type', 'text/html; charset=utf-8');
        $json = array('success' => true);
        
        //TODO: why textarea
        //$string = '<textarea>' . json_encode($json) . '</textarea>';
        $string = json_encode($json);
        $this->renderText($string);

        return sfView::NONE;
    }

}
