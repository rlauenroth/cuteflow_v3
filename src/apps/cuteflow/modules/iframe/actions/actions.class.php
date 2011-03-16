<?php

/**
 * iframe actions.
 *
 * @package    cf
 * @subpackage iframe
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class iframeActions extends sfActions {


    /**
     * Action loads an IFrame for the email, when settings are set IFRAME and HTML
     * the template getIframeSuccess.php adds the needed fields to the iframe
     * @param sfWebRequest $request
     * @return <type>
     */

    public function executeGetIFrame(sfWebRequest $request) {
        sfLoader::loadHelpers('Url', 'I18N');
        $serverUrl  = str_replace('/layout', '', url_for('layout/index', true));
        $versionId = $request->getParameter('versionid');
        $templateId = $request->getParameter('workflowid');
        $userId = $request->getParameter('userid');
        $userSettings = new UserMailSettings($userId);
        $context = sfContext::getInstance();

        $sf_i18n = $context->getI18N();
        $sf_i18n->setCulture($userSettings->userSettings['language']);


        $this->linkto = $context->getI18N()->__('Direct link to workflow' ,null,'sendstationmail');
        

        $wfSettings = WorkflowVersionTable::instance()->getWorkflowVersionById($versionId);
        $workflow = $wfSettings[0]->getWorkflowTemplate()->toArray();

        $detailObj = new WorkflowDetail(false);
        $detailObj->setServerUrl($serverUrl);
        $detailObj->setCulture($userSettings->userSettings['language']);
        $detailObj->setContext($context);
        

        $editObj = new WorkflowEdit(false);
        $editObj->setServerUrl($serverUrl);
        $editObj->setContext($context);
        $editObj->setCulture($userSettings->userSettings['language']);
        $editObj->setUserId($userId);
        $this->slots = $editObj->buildSlots($wfSettings , $versionId);


        $content['workflow'][0] = $context->getI18N()->__('You have to fill out the fields in the workflow' ,null,'sendstationmail');
        $content['workflow'][1] = $workflow[0]['name'];
        $content['workflow'][2] = $context->getI18N()->__('Slot' ,null,'sendstationmail');
        $content['workflow'][3] = $context->getI18N()->__('Yes' ,null,'sendstationmail');
        $content['workflow'][4] = $context->getI18N()->__('No' ,null,'sendstationmail');
        $content['workflow'][5] = $context->getI18N()->__('Field' ,null,'sendstationmail');
        $content['workflow'][6] = $context->getI18N()->__('Value' ,null,'sendstationmail');
        $content['workflow'][7] = $context->getI18N()->__('File' ,null,'sendstationmail');
        $content['workflow'][8] = $context->getI18N()->__('Accept Workflow' ,null,'sendstationmail');
        $content['workflow'][9] = $context->getI18N()->__('Deny Workflow' ,null,'sendstationmail');
        $content['workflow'][10] = $context->getI18N()->__('Save' ,null,'sendstationmail');

        $this->error = $request->getParameter('error',0);
        $this->serverPath = $serverUrl;
        $this->workflowverion = $versionId;
        $this->userid  = $userId;
        $this->workflow  = $templateId;
        $this->text = $content;
	$this->setLayout(false);
	$this->setTemplate('getIFrame');
        return sfView::SUCCESS;
    }

}
