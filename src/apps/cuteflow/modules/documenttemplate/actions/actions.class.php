<?php

/**
 * documenttemplate actions.
 *
 * @package    cf
 * @subpackage documenttemplate
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class documenttemplateActions extends sfActions {



    /**
     * Load all Fields for second tab in popup window when creating /editing documenttemplate
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadAllFields(sfWebRequest $request) {
        $fieldObj = new FieldClass();
        $result = FieldTable::instance()->getAllFields();
        $json_result = $fieldObj->buildField($result, $this->getContext());
        $this->renderText('({"result":'.json_encode($json_result).'})');
        return sfView::NONE;
    }

    /**
     * Save a documenttemplate
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeSaveDocumenttemplate(sfWebRequest $request) {
        $docObj = new Documenttemplate();
        $data = $request->getPostParameters();
        $docTemplate = new DocumenttemplateTemplate();
        $docTemplate->setName($data['documenttemplatePopUpFirstTab_fieldname']);
        $docTemplate->save();
        $template_id = $docTemplate->getId();
        $version_id = $docObj->storeVersion($template_id, 1);
        $slots = $data['slot'];
        $docObj->storeData($slots, $version_id);
        $this->renderText('{success:true}');
        return sfView::NONE;
    }


    /**
     * Update a documenttemplate, and create a new version
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeUpdateDocumenttemplate(sfWebRequest $request) {
        $docObj = new Documenttemplate();
        $data = $request->getPostParameters();
        DocumenttemplateVersionTable::instance()->setTemplateInactiveById($request->getParameter('id')); // set old template inactive
        $template_array = DocumenttemplateVersionTable::instance()->getDocumentTemplateId($request->getParameter('id'))->toArray(); // get old template
        $template_id = $template_array[0]['documenttemplate_id'];
        $version = $template_array[0]['version']+1;// create the nexte version of the template
        $version_id = $docObj->storeVersion($template_id, $version); // write new version
        $slots = $data['slot'];
        $docObj->storeData($slots, $version_id); // store slots
        $this->renderText('{success:true}');
        return sfView::NONE;
    }
    /**
     * Load all Documenttemplates for datagrid
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadAllDocumenttemplates(sfWebRequest $request) {
        $docObj = new Documenttemplate();
        $limit = $this->getUser()->getAttribute('userSettings');
        $anz = DocumenttemplateTemplateTable::instance()->getTotalSumOfDocumentTemplates();
        $data = DocumenttemplateTemplateTable::instance()->getAllDocumentTemplates($request->getParameter('limit',$limit['displayed_item']),$request->getParameter('start',0))->toArray();
        $json_result = $docObj->buildAllDocumenttemplates($data);
        $this->renderText('({"total":"'.$anz[0]->getAnzahl().'","result":'.json_encode($json_result).'})');
        return sfView::NONE;
    }


    /**
     * Load all documenttemplates by ajaxfilter
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadAllDocumenttemplatesByFilter(sfWebRequest $request) {
        $docObj = new Documenttemplate();
        $limit = $this->getUser()->getAttribute('userSettings');
        $anz = DocumenttemplateTemplateTable::instance()->getTotalSumOfDocumentTemplatesByFilter($request->getParameter('name'));
        $data = DocumenttemplateTemplateTable::instance()->getAllDocumentTemplatesByFilter($request->getParameter('limit',$limit['displayed_item']),$request->getParameter('start',0),$request->getParameter('name'))->toArray();
        $json_result = $docObj->buildAllDocumenttemplates($data);
        $this->renderText('({"total":"'.$anz[0]->getAnzahl().'","result":'.json_encode($json_result).'})');
        return sfView::NONE;
    }

    /**
     * Delete a documenttemplate
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeDeleteDocumenttemplate(sfWebRequest $request) {
        DocumenttemplateTemplateTable::instance()->deleteDocumentTemplateById($request->getParameter('id'));
        return sfView::NONE;
    }

    /**
     * Load a single Documenttemplate with slots and fields to edit it
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadSingleDocumenttemplate(sfWebRequest $request) {
        $docObj = new Documenttemplate();
        $data = DocumenttemplateTemplateTable::instance()->getDocumentTemplateById($request->getParameter('id'));
        $json_result = $docObj->buildSingleDocumenttemplates($data, $request->getParameter('id'), 'FIELDS');
        $this->renderText('({"result":'.json_encode($json_result).'})');
        return sfView::NONE;
    }


    /**
     * Load all versions of an template, for the popwindow
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadAllVersion(sfWebRequest $request) {
        $docObj = new Documenttemplate();
        $data = DocumenttemplateVersionTable::instance()->getAllVersionByTemplateId($request->getParameter('id'));
        $json_result = $docObj->buildAllVersion($data, $this->getUser()->getCulture(), $this->getContext());
        $this->renderText('({"result":'.json_encode($json_result).'})');
        return sfView::NONE;
    }


    /**
     * Activates a documenttemplate
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeActivateDocumenttemplate(sfWebRequest $request) {
        $document_id = $request->getParameter('documenttemplateid');
        $id = $request->getParameter('id');
        DocumenttemplateVersionTable::instance()->setAllTemplateInactiveByTemplateId($document_id); // set template inactive
        DocumenttemplateVersionTable::instance()->setTemplateActiveById($id); // set new template active
        return sfView::NONE;
    }









}
