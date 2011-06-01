<?php

/**
 * workflowoverview actions.
 *
 * @package    cf
 * @subpackage workflowoverview
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class workflowoverviewActions extends sfActions {



    /**
     * Load all workflows which are not in archive
     * 
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadAllWorkflow(sfWebRequest $request) {
        $workflow = new WorkflowOverview($this->getContext(), $this->getUser());
        $limit = $this->getUser()->getAttribute('userSettings');
        $workflow->setUserId($this->getUser()->getAttribute('id'));
        $workflow->setCulture($this->getUser()->getCulture());
        $anz = WorkflowTemplateTable::instance()->getAllWorkflowTemplates(-1, -1);
        $data = WorkflowTemplateTable::instance()->getAllWorkflowTemplates($request->getParameter('limit',$limit['displayed_item']),$request->getParameter('start',0));
        $json_data = $workflow->buildData($data, $request->getParameter('start',0));
        $this->renderText('({"total":"'.count($anz).'","result":'.json_encode($json_data).'})');
        return sfView::NONE;
    }

    /**
     * Stop a workflow and its running workflowprocesses
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeStopWorkflow(sfWebRequest $request) {
        WorkflowTemplateTable::instance()->stopWorkflow($request->getParameter('workflowtemplateid'), $this->getUser()->getAttribute('id'));
        $workflow = new WorkflowOverview($this->getContext(), $this->getUser());
        $workflow->setUserId($this->getUser()->getAttribute('id'));
        $workflow->setCulture($this->getUser()->getCulture());
        $data = WorkflowProcessUserTable::instance()->getWaitingStationToStopByUser($request->getParameter('versionid'));
        foreach($data as $itemToChange) {
                $pdoObj = Doctrine::getTable('WorkflowProcessUser')->find($itemToChange->getId());
                $pdoObj->setDecissionstate('STOPPEDBYADMIN');
                $pdoObj->setDateofdecission(time());
                $pdoObj->save();
        }
        return sfView::NONE;
    }


    /**
     * Delete a workflow, also stop its processes
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeDeleteWorkflow(sfWebRequest $request) {
        WorkflowTemplateTable::instance()->deleteAndStopWorkflow($request->getParameter('workflowtemplateid'), $this->getUser()->getAttribute('id'));
        $workflow = new WorkflowOverview($this->getContext(), $this->getUser());
        $workflow->setUserId($this->getUser()->getAttribute('id'));
        $workflow->setCulture($this->getUser()->getCulture());
        $data = WorkflowProcessUserTable::instance()->getWaitingStationToStopByUser($request->getParameter('versionid'));
        foreach($data as $itemToChange) {
                $pdoObj = Doctrine::getTable('WorkflowProcessUser')->find($itemToChange->getId());
                $pdoObj->setDecissionstate('DELETED');
                $pdoObj->setDateofdecission(time());
                $pdoObj->save();
        }

        return sfView::NONE;
    }

    /**
     * Move workflow to archive, and stop it
     * 
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeArchiveWorkflow(sfWebRequest $request) {
        WorkflowTemplateTable::instance()->archiveAndStopWorkflow($request->getParameter('workflowtemplateid'), $this->getUser()->getAttribute('id'));
        $workflow = new WorkflowOverview($this->getContext(), $this->getUser());
        $workflow->setUserId($this->getUser()->getAttribute('id'));
        $workflow->setCulture($this->getUser()->getCulture());
        $data = WorkflowProcessUserTable::instance()->getWaitingStationToStopByUser($request->getParameter('versionid'));
        foreach($data as $itemToChange) {
                $pdoObj = Doctrine::getTable('WorkflowProcessUser')->find($itemToChange->getId());
                $pdoObj->setDecissionstate('ARCHIVED');
                $pdoObj->setDateofdecission(time());
                $pdoObj->save();
        }
        return sfView::NONE;
    }

    /**
     * Start a workflow and its processes. Needed to start a workflow, also if it is started in future
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeStartWorkflow(sfWebRequest $request) {
        WorkflowVersionTable::instance()->startWorkflow($request->getParameter('versionid'));
        $workflowVersion = WorkflowTemplateTable::instance()->getWorkflowTemplateByVersionId($request->getParameter('versionid'));
        $template = MailinglistVersionTable::instance()->getSingleVersionById($workflowVersion[0]->getMailinglisttemplateversionId())->toArray();
        if($template[0]['sendtoallslotsatonce'] == 1) {
            $calc = new CreateWorkflow($request->getParameter('versionid'));
            $calc->addAllSlots();
        }
        else {
           $calc = new CreateWorkflow($request->getParameter('versionid'));
           $calc->addSingleSlot();
        }
        return sfView::NONE;
    }

    /**
     * Load all workflows, using the filter
     * 
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadAllWorkflowByFilter(sfWebRequest $request) {
        $limit = $this->getUser()->getAttribute('userSettings');
        $workflow = new WorkflowOverview($this->getContext(), $this->getUser());
        $workflow->setUserId($this->getUser()->getAttribute('id'));
        $workflow->setCulture($this->getUser()->getCulture());
        $filter = new FilterManagement();
        $filterOptions = $filter->checkFilter($request);
        $anz = WorkflowTemplateTable::instance()->getAllWorkflowTemplatesByFilter(-1, -1, $filterOptions);
        $data = WorkflowTemplateTable::instance()->getAllWorkflowTemplatesByFilter($request->getParameter('limit',$limit['displayed_item']),$request->getParameter('start',0),$filterOptions);
        $json_data = $workflow->buildData($data, $request->getParameter('start',0));
        $this->renderText('({"total":"'.count($anz).'","result":'.json_encode($json_data).'})');
        return sfView::NONE;
    }




}
