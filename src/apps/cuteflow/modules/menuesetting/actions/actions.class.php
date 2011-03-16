<?php

/**
 * menuesetting actions.
 *
 * @package    cf
 * @subpackage menuesetting
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class menuesettingActions extends sfActions {

    /**
     * loads all exisitng Modules, order them by position asc
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadModule (sfWebRequest $request) {
        $settingObj = new MenueSetting();

        $module = CredentialTable::instance()->getAllUsermodule('c.usermoduleposition asc');

        $settingObj->setContext($this->getContext());
        $json_result = $settingObj->buildModule($module);

        $this->renderText('{"result":'.json_encode($json_result).'}');
        return sfView::NONE;

    }

    /**
     * Save new order of Modules
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeSaveModule(sfWebRequest $request) {
        $data = $request->getPostParameters();      
        CredentialTable::instance()->saveOrderOfModules($data['grid'], 1);
        $this->renderText('{success:true}');
        return sfView::NONE;
    }



    /**
     * Functions loads menue elements for a usermodule, ordered by position asc
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadGroup (sfWebRequest $request) {
        $settingObj = new MenueSetting();
        $groups = CredentialTable::instance()->getAllGroups($request->getParameter('id'),'c.usergroupposition ASC');
        
        $settingObj->setContext($this->getContext());
        $json_result = $settingObj->buildGroup($groups);

        $this->renderText('{"result":'.json_encode($json_result).'}');
        return sfView::NONE;

    }

    /**
     * Save new order of usermodulegroup
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeSaveGroup(sfWebRequest $request) {     
        CredentialTable::instance()->saveOrderOfGroups($request->getPostParameters(), 1);
        $this->renderText('{success:true}');
        return sfView::NONE;
    }










}
