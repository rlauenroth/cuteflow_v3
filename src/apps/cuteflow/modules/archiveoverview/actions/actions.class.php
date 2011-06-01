<?php

/**
 * archiveoverview actions.
 *
 * @package    cf
 * @subpackage archiveoverview
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class archiveoverviewActions extends sfActions {



    /**
     * Actions loads alle archived workflows for the overview
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadAllArchivedWorkflow(sfWebRequest $request) {
        $limit = $this->getUser()->getAttribute('userSettings');
        $workflow = new WorkflowOverview($this->getContext(), $this->getUser());
        $workflow->setUserId($this->getUser()->getAttribute('id'));
        $workflow->setCulture($this->getUser()->getCulture());
        $anz = WorkflowTemplateTable::instance()->getArchivedWorkflowTemplates(-1,-1);
        $data = WorkflowTemplateTable::instance()->getArchivedWorkflowTemplates($request->getParameter('limit',$limit['displayed_item']),$request->getParameter('start',0));
        $json_data = $workflow->buildData($data, $request->getParameter('start',0));
        $this->renderText('({"total":"'.count($anz).'","result":'.json_encode($json_data).'})');
        return sfView::NONE;
    }


    /**
     * Action removes a Workflow from Archive
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeRemoveFromArchive(sfWebRequest $request) {
        WorkflowTemplateTable::instance()->removeFromArchive($request->getParameter('workflowtemplateid'), $this->getUser()->getAttribute('id'));
        return sfView::NONE;
    }


    /**
     * Load all workflows, when filter functionality is used
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadAllArchivedWorkflowByFilter(sfWebRequest $request) {
        $limit = $this->getUser()->getAttribute('userSettings');
        $workflow = new WorkflowOverview($this->getContext(), $this->getUser());
        $workflow->setUserId($this->getUser()->getAttribute('id'));
        $workflow->setCulture($this->getUser()->getCulture());
        $filter = new FilterManagement();
        $filterOptions = $filter->checkFilter($request);
        $anz = WorkflowTemplateTable::instance()->getAllArchivedWorkflowTemplatesByFilter(-1,-1, $filterOptions);
        $data = WorkflowTemplateTable::instance()->getAllArchivedWorkflowTemplatesByFilter($request->getParameter('limit',$limit['displayed_item']),$request->getParameter('start',0), $filterOptions);
        $json_data = $workflow->buildData($data, $request->getParameter('start',0));
        $this->renderText('({"total":"'.count($anz).'","result":'.json_encode($json_data).'})');
        return sfView::NONE;
    }

}
