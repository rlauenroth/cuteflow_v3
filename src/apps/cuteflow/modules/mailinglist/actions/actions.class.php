<?php

/**
 * mailinglist actions.
 *
 * @package    cf
 * @subpackage mailinglist
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class mailinglistActions extends sfActions {



    /**
     * Load all mailininglist
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadAllMailinglists(sfWebRequest $request) {
        $mailinglist = new Mailinglist();
        $limit = $this->getUser()->getAttribute('userSettings');
        $data = MailinglistTemplateTable::instance()->getAllMailinglistTemplates($request->getParameter('limit',$limit['displayed_item']),$request->getParameter('start',0));
        $anz = MailinglistTemplateTable::instance()->getTotalSumOfMailingListTemplates();
        $json_result = $mailinglist->buildAllMailinglists($data);
        $this->renderText('({"total":"'.$anz[0]->getAnzahl().'","result":'.json_encode($json_result).'})');
        return sfView::NONE;
    }


    /**
     * Load Mailinglist by ajaxfilter
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadAllMailinglistsByFilter(sfWebRequest $request) {
        $mailinglist = new Mailinglist();
        $limit = $this->getUser()->getAttribute('userSettings');
        $data = MailinglistTemplateTable::instance()->getAllMailinglistTemplatesByFilter($request->getParameter('limit',$limit['displayed_item']),$request->getParameter('start',0),$request->getParameter('name'));
        $anz = MailinglistTemplateTable::instance()->getTotalSumOfMailingListTemplatesByFilter($request->getParameter('name'));
        $json_result = $mailinglist->buildAllMailinglists($data);
        $this->renderText('({"total":"'.$anz[0]->getAnzahl().'","result":'.json_encode($json_result).'})');
        return sfView::NONE;
    }


    /**
     * build the receiver for a mailinglist
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeBuildReceiver(sfWebRequest $request) {
        $mailinglist = new Mailinglist();
        $result = UserDataTable::instance()->getAllUserFullname();
        $json_result = $mailinglist->buildReceiver($result);
        $this->renderText('{"result":'.json_encode($json_result).'}');
        return sfView::NONE;
    }

    /**
     * Load all Documenttemplates
     * 
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadAllDocuments(sfWebRequest $request) {
        $result = DocumentTemplateTable::instance()->getAllDocumentTemplates(-1,-1)->toArray();
        $this->renderText('{"result":'.json_encode($result).'}');
        return sfView::NONE;
    }

    /**
     * Loads all users, which are allowed to send workflows
     * 
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadAllSender(sfWebRequest $request) {
        $result = UserLoginTable::instance()->getAllSenderUser()->toArray();
        $this->renderText('{"result":'.json_encode($result).'}');
        return sfView::NONE;
    }



    /**
     * Load a form without user
     * 
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadFormWithoutUser(sfWebRequest $request) {
        $docObj = new Documenttemplate();
        $id = DocumentTemplateVersionTable::instance()->getActiveVersionById($request->getParameter('id'))->toArray();
        $data = DocumentTemplateTable::instance()->getDocumentTemplateById($id[0]['id']);
        $result = $docObj->buildSingleDocumenttemplates($data, $id[0]['id'], 'SLOTSONLY');
        $this->renderText('{"result":'.json_encode($result).'}');
        return sfView::NONE;
    }



    /**
     * Saves a new mailinglist
     * 
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeSaveMailinglist(sfWebRequest $request) {
        $mailinglist = new Mailinglist();
        $data = $request->getPostParameters();
        $sendToAll = isset($data['mailinglistFirstTab_sendtoallslots'])  ? 1 : 0;
        $activeVersion = DocumentTemplateVersionTable::instance()->getActiveVersionById($data['mailinglistFirstTab_documenttemplate'])->toArray();
        $mailinglisttemplate = new MailinglistTemplate();
        $mailinglisttemplate->setName($data['mailinglistFirstTab_nametextfield']);
        $mailinglisttemplate->setIsActive(0);
        $mailinglisttemplate->setDocumentTemplateId($data['mailinglistFirstTab_documenttemplate']);
        $mailinglisttemplate->save();
        $mailinglist_template_id = $mailinglisttemplate->getId();
        $mailinglist_version_id = $mailinglist->storeVersion($mailinglist_template_id, 1, $activeVersion[0]['id'], $sendToAll); // store the list
        
        $mailinglist->saveAuthorization($mailinglist_version_id, $data['auth']); // save auth settings
        $mailinglist->saveUser($mailinglist_version_id, isset($data['user']) ? $data['user'] : array()); // save allowed user
        $slots = $data['slot'];
        $mailinglist->storeMailinglist($slots, $mailinglist_version_id); // save the users for the slots
        $this->renderText('{success:true}');
        return sfView::NONE;
    }

     /**
     * Update a mailinglist
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeUpdateMailinglist(sfWebRequest $request) {
        $mailinglist = new Mailinglist();
        $data = $request->getPostParameters();
        $sendToAll = isset($data['mailinglistFirstTab_sendtoallslots'])  ? 1 : 0;
        // create the next version for the mailinglist
        $mailingsdata = MailinglistVersionTable::instance()->getVersionById($request->getParameter('id'))->toArray();
        MailinglistVersionTable::instance()->setMailinglistInactiveById($request->getParameter('id'));
        // save mailinglist
        $mailinglist_version_id = $mailinglist->storeVersion($mailingsdata[0]['mailinglist_template_id'],$mailingsdata[0]['version']+1, $mailingsdata[0]['document_template_version_id'], $sendToAll);
        $mailinglist->saveAuthorization($mailinglist_version_id, $data['auth']); // save auth settings
        $mailinglist->saveUser($mailinglist_version_id, isset($data['user']) ? $data['user'] : array()); // save allowed user
        $slots = $data['slot'];
        $mailinglist->storeMailinglist($slots, $mailinglist_version_id); // save the users for the slot
        $this->renderText('{success:true}');
        return sfView::NONE;
    }
    
    /**
     * Set a mailinglist to standard
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeSetStandard(sfWebRequest $request) {
        MailinglistTemplateTable::instance()->setAllTemplatesDisabledById();
        MailinglistTemplateTable::instance()->activateTemplateById($request->getParameter('id'));
        return sfView::NONE;
    }

    /**
     * Delete an Mailinglist
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeDeleteMailinglist(sfWebRequest $request) {
        MailinglistTemplateTable::instance()->deleteMailinglistTemplateById($request->getParameter('id'));
        return sfView::NONE;
    }

    /**
     * Load Mailinglist by ajaxfilter
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadAllMailinglistsFilter(sfWebRequest $request) {
        $mailinglist = new Mailinglist();
        $limit = $this->getUser()->getAttribute('userSettings');
        $search = $request->getParameter('name');
        $data = MailinglistTemplateTable::instance()->getAllMailinglistTemplatesByFilter($request->getParameter('limit',$limit['displayed_item']),$request->getParameter('start',0),$search);
        $anz = MailinglistTemplateTable::instance()->getTotalSumOfMailingListTemplatesByFilter($search);
        $json_result = $mailinglist->buildAllMailinglists($data);
        $this->renderText('({"total":"'.$anz[0]->getAnzahl().'","result":'.json_encode($json_result).'})');
        return sfView::NONE;
    }

    /**
     * Load Authorization settings for an exisiting template
     * 
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadAuthorization(sfWebRequest $request) {
        $sysObj = new SystemSetting();
        $auth = new MergeAuthorization();
        $data = MailinglistAuthorizationSettingTable::instance()->getAuthorizationById($request->getParameter('id'))->toArray();
        $defaultRole = AuthorizationConfigurationTable::instance()->getAllRoles()->toArray();
        $worklfosettings = $sysObj->buildAuthorizationColumns($data, $this->getContext());
        $allRoles = RoleTable::instance()->getAllRole()->toArray();
        $mergedRoles = $auth->mergeRoles($allRoles, $defaultRole, $worklfosettings);
        
        $this->renderText('{"result":'.json_encode($mergedRoles).'}');
        return sfView::NONE;
    }

    /**
     * Load auth for editing template
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadDefaultAuthorization(sfWebRequest $request) {
        $sysObj = new SystemSetting();
        $auth = new MergeAuthorization();
        $authorization = AuthorizationConfigurationTable::instance()->getAuthorizationConfiguration(false)->toArray();
        $defaultRole = AuthorizationConfigurationTable::instance()->getAllRoles()->toArray();
        $worklfosettings = $sysObj->buildAuthorizationColumns($authorization, $this->getContext());
        $allRoles = RoleTable::instance()->getAllRole()->toArray();
        $mergedRoles = $auth->mergeRoles($allRoles, $defaultRole, $worklfosettings);
        $this->renderText('{"result":'.json_encode($mergedRoles).'}');
        return sfView::NONE;
    }

    /**
     * Load all sender with sending rights
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadAllAllowedSender(sfWebRequest $request) {
        $mailinglist = new Mailinglist();
        $data = MailinglistAllowedSenderTable::instance()->getAllowedSenderById($request->getParameter('id'))->toArray();
        $data = $mailinglist->buildAllowedSender($data);
        $this->renderText('{"result":'.json_encode($data).'}');
        return sfView::NONE;
    }


    /**
     * Load a Mailinglist template including users (when in editmode)
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadFormWithUser(sfWebRequest $request) {
        $mailinglist = new Mailinglist();
        $data = MailinglistTemplateTable::instance()->getMailinglistById($request->getParameter('id'));
        $json_result = $mailinglist->buildSingleMailinglist($data);
        $this->renderText('{"result":'.json_encode($json_result).'}');
        return sfView::NONE;
    }
    
    /**
     * Load name of an single Mailinglist
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadSingleMailinglist(sfWebRequest $request) {
        $mailObj = new Mailinglist();
        $mailObj->setContext($this->getContext());
        $mailinglist = MailinglistTemplateTable::instance()->getMailinglistByVersionId($request->getParameter('id'));
        $data = $mailObj->buildSingleMailinglist($mailinglist, $request->getParameter('id'));
        $this->renderText('{"result":'.json_encode($data).'}');
        return sfView::NONE;
    }


    public function executeDummy(sfWebRequest $request) {
        $json_data = array();
        $this->renderText('{"result":'.json_encode($json_data).'}');
        return sfView::NONE;
    }



    /**
     * Load all versions of an existing template
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadAllVersion(sfWebRequest $request) {
        $mailinglist = new Mailinglist();
        $mailinglist->setContext($this->getContext());
        $result = MailinglistVersionTable::instance()->getAllVersionsById($request->getParameter('id'));
        $json_result = $mailinglist->buildAllVersion($result, $this->getUser()->getCulture());
        $this->renderText('({"result":'.json_encode($json_result).'})');
        return sfView::NONE;
    }


    /**
     * Activate a mailinglist from history
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeActivateMailinglist(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $mailinglist_id = $request->getParameter('mailinglistid');
        MailinglistVersionTable::instance()->setMailinglistInactiveById($mailinglist_id);
        MailinglistVersionTable::instance()->setMailinglistActiveById($id);
        return sfView::NONE;
    }


    /**
     * Adapt mailinglist to current version
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeAdaptMailinglist(sfWebRequest $request) {
        $mailinglist = new Mailinglist();
        $docuObj = new Documenttemplate();
        $mailinglistdata = MailinglistTemplateTable::instance()->getMailinglistByVersionTemplateId($request->getParameter('id'))->toArray();
        $currentdocumenttemplateversion = DocumentTemplateVersionTable::instance()->getActiveVersionById($mailinglistdata[0]['documenttemplatetemplate_id'])->toArray();
        $slots = $docuObj->buildSlots($currentdocumenttemplateversion[0]['id'], 'SLOTSONLY');
        $mailinglistversiondata = MailinglistVersionTable::instance()->getActiveVersionById($request->getParameter('id'))->toArray();
        MailinglistVersionTable::instance()->setMailinglistInactiveById($mailinglistversiondata[0]['mailinglist_template_id']);
        $mailinglist_version_id = $mailinglist->storeVersion($mailinglistversiondata[0]['mailinglist_template_id'],$mailinglistversiondata[0]['version']+1, $currentdocumenttemplateversion[0]['id']);
        $userdata = MailinglistAllowedSenderTable::instance()->getAllowedSenderById($mailinglistversiondata[0]['id']);
        $users = $mailinglist->buildAllowedUser($userdata);
        $mailinglist->saveUser($mailinglist_version_id, isset($users) ? $users: array());
        $authdata = MailinglistAuthorizationSettingTable::instance()->getAuthorizationById($mailinglistversiondata[0]['id'])->toArray();
        $mailinglist->adaptAuthorizationEntry($authdata, $mailinglist_version_id);
        $mailinglist->storeMailinglist($slots, $mailinglist_version_id);
        return sfView::NONE;
    }



}
