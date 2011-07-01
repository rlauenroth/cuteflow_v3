<?php

/**
 * workflowdetail actions.
 *
 * @package    cf
 * @subpackage workflowdetail
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class workflowdetailActions extends sfActions
{

    /**
     * Load details for a single workflow, 
     * generalData like sender, creation date is loaded
     * detailData, to modifiy running worklfow, e.g. resent, or leave one out
     * workflowData, current values of the fields
     * workflowAttachment, load public attachments
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadWorkflowDetails(sfWebRequest $request) {
        $detailsObj = new WorkflowDetail();
        $detailsObj->setUser($this->getUser());
        $detailsObj->setCulture($this->getUser()->getCulture());
        $detailsObj->setContext($this->getContext());
        $workflowsettings = WorkflowVersionTable::instance()->getWorkflowVersionById($request->getParameter('versionid'));
        $generalData = $detailsObj->buildHeadLine($workflowsettings);
        $userData = $detailsObj->buildUserData($workflowsettings, $request->getParameter('versionid'));
        $workflowData = $detailsObj->buildWorkflowData($workflowsettings, $request->getParameter('versionid'));
        $attachments = $detailsObj->buildAttachments($workflowsettings, $request->getParameter('versionid'));        
        $this->renderText('{"generalData":'.json_encode($generalData).', "detailData" : '.json_encode($userData).', "workflowData" : '.json_encode($workflowData).', "workflowAttachment" : '.json_encode($attachments).'}');
        return sfView::NONE;
    }

    /**
     * Resend emial to selected station
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeResendEmail(sfWebRequest $request) {
        $serverUrl = str_replace('/layout', '', url_for('layout/index',true));
        $context = sfContext::getInstance();
        $versionId = $request->getParameter('versionid');
        $user_id = $request->getParameter('userid');
        $workflow = WorkflowVersionTable::instance()->getWorkflowVersionById($versionId)->toArray();
        $test = new PrepareStationEmail($versionId, $workflow[0]['workflow_template_id'], $user_id, $context, $serverUrl);
        return sfView::NONE;
    }


    /**
     * Load a previos version of the workflow, when combobox is used
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadVersion(sfWebRequest $request) {
        $detailsObj = new WorkflowDetail();
        $detailsObj->setUser($this->getUser());
        $detailsObj->setCulture($this->getUser()->getCulture());
        $detailsObj->setContext($this->getContext());
        $workflowsettings = WorkflowVersionTable::instance()->getWorkflowVersionById($request->getParameter('versionid'));
        $userData = $detailsObj->buildUserData($workflowsettings, $request->getParameter('versionid'));
        $workflowData = $detailsObj->buildWorkflowData($workflowsettings, $request->getParameter('versionid'));
        $attachments = $detailsObj->buildAttachments($workflowsettings, $request->getParameter('versionid'));

        $this->renderText('{"detailData" : '.json_encode($userData).', "workflowData" : '.json_encode($workflowData).', "workflowAttachment" : '.json_encode($attachments).'}');
        return sfView::NONE;
    }


    /**
     * Skip a station, and calculate next
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeSkipStation(sfWebRequest $request) {
        WorkflowProcessUserTable::instance()->skipStation($request->getParameter('workflowprocessuserid'));
        $context = sfContext::getInstance();
        $context->getConfiguration()->loadHelpers('Partial', 'I18N', 'Url', 'Date', 'CalculateDate', 'ColorBuilder', 'Icon', 'EndAction');
        $saveWf = new SaveWorkflow();
        $saveWf->setContext($context);
        $saveWf->setServerUrl(str_replace('/layout', '', url_for('layout/index',true)));

        $checkWorkflow = new CreateNextStation($request->getParameter('versionid'),$request->getParameter('workflowslotid'),$request->getParameter('workflowslotuserid'),$saveWf);


        $detailsObj = new WorkflowDetail();
        $detailsObj->setUser($this->getUser());
        $detailsObj->setCulture($this->getUser()->getCulture());
        $detailsObj->setContext($this->getContext());
        $workflowsettings = WorkflowVersionTable::instance()->getWorkflowVersionById($request->getParameter('versionid'));
        $userData = $detailsObj->buildUserData($workflowsettings, $request->getParameter('versionid'));
       
        
        $this->renderText('{"detailData" : '.json_encode($userData).'}');
        return sfView::NONE;
    }


    /**
     * Load all stations of the workflow for an overview, finally user can jump into another station
     * 
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadAllStations(sfWebRequest $request) {
        $detailsObj = new WorkflowDetail();
        $detailsObj->setUser($this->getUser());
        $detailsObj->setCulture($this->getUser()->getCulture());
        $detailsObj->setContext($this->getContext());
        $workflowsettings = WorkflowVersionTable::instance()->getWorkflowVersionById($request->getParameter('versionid'));
        $userData = $detailsObj->buildUserData($workflowsettings, $request->getParameter('versionid'));
        #print_r ($userData);die;
        $this->renderText('{"detailData" : '.json_encode($userData).'}');
        return sfView::NONE;
    }



    /**
     * Add a useragent manually
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeSetUseragent(sfWebRequest $request) {
        $user_agent_id = $request->getParameter('userid');
        $workflow_process_id = $request->getParameter('workflowprocessuserid');
        $version_id = $request->getParameter('versionid');
        $currentVersion = WorkflowProcessUserTable::instance()->getProcessById($workflow_process_id)->toArray();
        $workflowId = WorkflowVersionTable::instance()->getWorkflowVersionById($version_id)->toArray();
        $context = sfContext::getInstance();
        $context->getConfiguration()->loadHelpers('Partial', 'I18N', 'Url', 'Date', 'CalculateDate', 'ColorBuilder', 'Icon', 'EndAction');

        $processObj = new WorkflowProcessUser();
        $processObj->setWorkflowProcessId($currentVersion[0]['workflow_process_id']);
        $processObj->setWorkflowSlotUserId($currentVersion[0]['workflow_slot_user_id']);
        $processObj->setUserId($user_agent_id);
        $processObj->setInProgressSince(time());
        $processObj->setDecissionState('WAITING');
        $processObj->setUseragentsetbycronjob(0);
        $processObj->setIsUserAgentOf($workflow_process_id);
        $processObj->setResendet(0);
        $processObj->save();
        WorkflowProcessUserTable::instance()->setProcessToUseragentSet($workflow_process_id);

        $mailObj = new PrepareStationEmail($version_id, $workflowId[0]['workflow_template_id'], $user_agent_id, $context,str_replace('/layout', '', url_for('layout/index',true)));


        $detailsObj = new WorkflowDetail();
        $detailsObj->setUser($this->getUser());
        $detailsObj->setCulture($this->getUser()->getCulture());
        $detailsObj->setContext($this->getContext());

        $workflowsettings = WorkflowVersionTable::instance()->getWorkflowVersionById($version_id);
        $userData = $detailsObj->buildUserData($workflowsettings, $version_id);
        $this->renderText('{"detailData" : '.json_encode($userData).'}');
        return sfView::NONE;
    }

    /**
     * Save the selected station from the popup
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeSetNewStation(sfWebRequest $request) {
        $context = sfContext::getInstance();
        $context->getConfiguration()->loadHelpers('Partial', 'I18N', 'Url', 'Date', 'CalculateDate', 'ColorBuilder', 'Icon', 'EndAction');
        $calc = new SetStation($request->getParameter('versionid'),$request->getParameter('newworkflowuserslotid'), $request->getParameter('currentworkflowuserslotid'), $request->getParameter('direction'), $context, str_replace('/layout', '', url_for('layout/index',true)));


        $detailsObj = new WorkflowDetail();
        $detailsObj->setUser($this->getUser());
        $detailsObj->setCulture($this->getUser()->getCulture());
        $detailsObj->setContext($this->getContext());

        $workflowsettings = WorkflowVersionTable::instance()->getWorkflowVersionById($request->getParameter('versionid'));
        $userData = $detailsObj->buildUserData($workflowsettings, $request->getParameter('versionid'));
        $this->renderText('{"detailData" : '.json_encode($userData).'}');
        return sfView::NONE;
    }


}
