<?php

/**
 * filter actions for workflooverview, todo, archiveoverview
 *
 * @package    cf
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class filterActions extends sfActions
{


    /**
     * Load all mailinglist
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadMailinglist(sfWebRequest $request) {
        $mailinglist = new Mailinglist();
        $data = MailinglistTemplateTable::instance()->getAllMailinglistTemplates(-1,-1);
        $json_result = $mailinglist->buildAllMailinglists($data);
        $this->renderText('({"result":'.json_encode($json_result).'})');
        return sfView::NONE;
    }


    /**
     * Load all Documenttemplates
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadDocumenttemplate(sfWebRequest $request) {
        $docObj = new Documenttemplate();
        $data = DocumentTemplateTable::instance()->getAllDocumentTemplates(-1,-1)->toArray();
        $json_result = $docObj->buildAllDocumenttemplates($data);
        $this->renderText('({"result":'.json_encode($json_result).'})');
        return sfView::NONE;
    }


    /**
     * Load all user, which are able to send a worklfow
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadSender(sfWebRequest $request) {
        $result = UserLoginTable::instance()->getAllSenderUser()->toArray();
        $this->renderText('{"result":'.json_encode($result).'}');
        return sfView::NONE;
    }

    /**
     * Load all stations, which are running
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadStation(sfWebRequest $request) {
        $filter = new FilterManagement();
        $data = WorkflowProcessUserTable::instance()->getWaitingProcess();
        $json_data = $filter->getRunningStation($data);
        $this->renderText('{"result":'.json_encode($json_data).'}');
        return sfView::NONE;
    }

    /**
     * Load all available fields
     * 
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadFields(sfWebRequest $request) {
        $fieldObj = new FieldClass();
        $result = FieldTable::instance()->getAllFields();
        $json_result = $fieldObj->buildField($result, $this->getContext());
        $this->renderText('({"result":'.json_encode($json_result).'})');
        return sfView::NONE;
    }


    /**
     * Save a created filter
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeSaveFilter(sfWebRequest $request) {
		
        $sender_id = $request->getPostParameter('filter_sender') == '' ? -1 : $request->getPostParameter('filter_sender');
        $currentStation_id = $request->getPostParameter('filter_currentstation') == '' ? -1 : $request->getPostParameter('filter_currentstation');
        $mailingList = $request->getPostParameter('filter_mailinglist') == '' ? -1 : $request->getPostParameter('filter_mailinglist');
        $documentTemplate = $request->getPostParameter('filter_documenttemplate') == '' ? -1 : $request->getPostParameter('filter_documenttemplate');

        $filter = new Filter();
        $filter->setFiltername($request->getPostParameter('filter_hiddenname',''));
        $filter->setName($request->getPostParameter('filter_name',''));
        $filter->setSenderId($sender_id);
        $filter->setDaysfrom($request->getPostParameter('filter_daysinprogress_from',''));
        $filter->setDaysto($request->getPostParameter('filter_daysinprogress_to',''));
        $filter->setSendetfrom($request->getPostParameter('filter_sendet_from',''));
        $filter->setSendetto($request->getPostParameter('filter_sendet_to',''));
        $filter->setWorkflowprocessuserId($currentStation_id);
        $filter->setMailinglistVersionId($mailingList);
        $filter->setDocumentTemplateVersionId($documentTemplate);
        $filter->save();
        $filterId = $filter->getId();
        // save the field grid
        if($request->hasParameter('field')) {
            $fields = $request->getParameter('field');
            $operators = $request->getParameter('operator');
            $values = $request->getParameter('value');
            foreach($fields as $key => $field) {
                $operator = $operators[$key];
                $value = $values[$key];
                if($field != '' AND $operator != '' AND $value != '') {
                    $filterField = new FilterField();
                    $filterField->setFilterId($filterId);
                    $filterField->setFieldId($field);
                    $filterField->setOperator($operator);
                    $filterField->setValue($value);
                    $filterField->save();
                }
                
            }
        }


        $this->renderText('{success:true}');
        return sfView::NONE;
    }


    /**
     * Load all filters from database
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadFilter(sfWebRequest $request) {
        $data = FilterTable::instance()->getAllFilter()->toArray();
        $this->renderText('({"result":'.json_encode($data).'})');
        return sfView::NONE;
    }



    /**
     * Load a single filter
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadSingleFilter(sfWebRequest $request) {
        $filtObj = new FilterManagement();
        $filters = FilterTable::instance()->getFilterById($request->getParameter('id'));
        $json_data = $filtObj->buildFilter($filters);
        $this->renderText('({"result":'.json_encode($json_data).'})');
        return sfView::NONE;
    }

    /**
     * Delete a filter
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeDeleteFilter(sfWebRequest $request) {
        FilterFieldTable::instance()->deleteFieldsByFilterId($request->getParameter('id'));
        $filter = Doctrine::getTable('Filter')->find($request->getParameter('id'));
        $filter->delete();
        return sfView::NONE;
    }
}
