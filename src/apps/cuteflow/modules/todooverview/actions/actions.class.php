<?php

/**
 * todooverview actions.
 *
 * @package    cf
 * @subpackage todooverview
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class todooverviewActions extends sfActions {


    /**
     * Load all worklfows, which a user has to fill
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadAllOwnWorkflow(sfWebRequest $request) {
        $limit = $this->getUser()->getAttribute('userSettings');
        $workflow = new WorkflowOverview($this->getContext(), $this->getUser());
        $workflow->setUserId($this->getUser()->getAttribute('id'));
        $workflow->setCulture($this->getUser()->getCulture());
        $anz = WorkflowTemplateTable::instance()->getAllToDoWorkflowTemplates(-1,-1,$this->getUser()->getAttribute('id'));
        $data = WorkflowTemplateTable::instance()->getAllToDoWorkflowTemplates($request->getParameter('limit',$limit['displayed_item']),$request->getParameter('start',0),$this->getUser()->getAttribute('id'));
        $json_data = $workflow->buildData($data, $request->getParameter('start',0));
        $this->renderText('({"total":"'.count($anz).'","result":'.json_encode($json_data).'})');
        return sfView::NONE;
    }


    /**
     * Load all worklflows a user has to fill, when filter is used
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadAllOwnWorkflowByFilter(sfWebRequest $request) {
        $limit = $this->getUser()->getAttribute('userSettings');
        $workflow = new WorkflowOverview($this->getContext(), $this->getUser());
        $workflow->setUserId($this->getUser()->getAttribute('id'));
        $workflow->setCulture($this->getUser()->getCulture());
        $filter = new FilterManagement();
        $filterOptions = $filter->checkFilter($request);
        $anz = WorkflowTemplateTable::instance()->getAllToDoWorkflowTemplatesByFilter(-1,-1,$this->getUser()->getAttribute('id'), $filterOptions);
        $data = WorkflowTemplateTable::instance()->getAllToDoWorkflowTemplatesByFilter($request->getParameter('limit',$limit['displayed_item']),$request->getParameter('start',0),$this->getUser()->getAttribute('id'), $filterOptions);

        $json_data = $workflow->buildData($data, $request->getParameter('start',0));
        $this->renderText('({"total":"'.count($anz).'","result":'.json_encode($json_data).'})');
        return sfView::NONE;
    }

}
