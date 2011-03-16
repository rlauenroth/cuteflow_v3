<?php

/**
* usermanagement actions.
*
* @package    cf
* @subpackage usermanagement
* @author     Your name here
* @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
*/
class usermanagementActions extends sfActions {
    
    /**
    *
    * Function loads all Users for Datagrid overview.
    *
    * @param sfWebRequest $request
    * @return <type>
    */
    public function executeLoadAllUser(sfWebRequest $request) {
        $json_result = array();
        $usermanagement = new Usermanagement();


        $anz = UserLoginTable::instance()->getTotalSumOfUser();
        $limit = $this->getUser()->getAttribute('userSettings');
        $result = UserLoginTable::instance()->getAllUser($request->getParameter('limit',$limit['displayeditem']),$request->getParameter('start',0));

        $json_result = $usermanagement->buildUser($result, $this->getRequestParameter('start',0)+1);

        $data = '({"total":"'.$anz[0]->getAnzahl().'","result":'.json_encode($json_result).'})';
        $this->renderText($data);

        return sfView::NONE;
    }


    /**
    *
    * Filter functionality for User Grid
    *
    * @param sfWebRequest $request
    * @return <type>
    */
    public function executeLoadAllUserFilter(sfWebRequest $request) {
        $json_result = array();
        $usermanagement = new Usermanagement();
        $limit = $this->getUser()->getAttribute('userSettings');
        
        $anz = UserLoginTable::instance()->getTotalSumOfUserByFilter($request);
        $result = UserLoginTable::instance()->getAllUserByFilter($limit['displayeditem'],$request->getParameter('start',0),$request);
        
        $json_result = $usermanagement->buildUser($result, $this->getRequestParameter('start',0)+1);

        $data = '({"total":"'.$anz[0]->getAnzahl().'","result":'.json_encode($json_result).'})';
        $this->renderText($data);

        return sfView::NONE;
    }


    /**
    *
    * Loads all Roles for the Combobox in the filter.
    * Is only called when combo is opend first time
    *
    * @param sfWebRequest $request
    * @return <type>
    */
    public function executeLoadAllRole(sfWebRequest $request) {
        $usermanagement = new Usermanagement();
        $result = RoleTable::instance()->getAllRole();
        $json_result = $usermanagement->buildRole($result,0);
        $this->renderText('({"result":'.json_encode($json_result).'})');
        return sfView::NONE;
    }

    /**
    *
    * Function removes user from database.
    *
    * @param sfWebRequest $request
    * @return <type>
    */
    public function executeDeleteUser(sfWebRequest $request) {
        UserLoginTable::instance()->deleteUser($request->getParameter('id'), $this->getUser()->getAttribute('id'));
        return sfView::NONE;
    }

    
    /**
     * Function loads Users for left grid when adding user agents
     * 
     * @param sfWebRequest $reques
     * @return <type> 
     */
    public function executeLoadUserGrid(sfWebRequest $request) {
        $usermanagement = new Usermanagement();
        $result = UserDataTable::instance()->getAllUserFullname();
        $json_result = $usermanagement->buildUserGrid($result);
        $this->renderText('{"result":'.json_encode($json_result).'}');
        return sfView::NONE;
    }

    /**
     * Functions loads useragents when in edit mode
     *
     * @param sfWebRequest $request
     */
    public function executeLoadUserAgentGrid(sfWebRequest $request) {
        $usermanagement = new Usermanagement();
        $result = UserAgentTable::instance()->getAllUserAgentForSingleUser($request->getParameter('id'));
        $json_result = $usermanagement->builUserAgentGrid($result);
        $this->renderText('{"result":'.json_encode($json_result).'}');
        return sfView::NONE;
    }

    /**
     * Checks if an user is already in database stored
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeCheckForExistingUser(sfWebRequest $request) {
        $result = UserLoginTable::instance()->findUserByUsername($request->getParameter('username'));
        if($result[0]->getUsername() == $request->getParameter('username')) {
            $this->renderText('0'); // no write access
        }
        else {
            $this->renderText('1'); // write access
        }
        return sfView::NONE;
    }


    /**
     *
     * Loads Data to edit a single User
     * 
     * @param sfWebRequest $request
     */
    public function executeLoadSingleUser(sfWebRequest $request) {
        $usermanagement = new Usermanagement();
        $result = UserLoginTable::instance()->findUserById($request->getParameter('id'));
        $json_result = $usermanagement->buildSingleUser($result);
        $this->renderText('{"result":'.json_encode($json_result).'}');
        return sfView::NONE;
    }

    /**
     * Store function when edit user
     *
     * @param sfWebRequest $request
     */
    public function executeUpdateUser(sfWebRequest $request) {
        $store = new UserCRUD();
        $data = $store->prepareUpdateData($request->getPostParameters());
        UserLoginTable::instance()->updateUser($data, $request->getParameter('id'));
        UserDataTable::instance()->updateUserFirstnameAndLastname($data, $request->getParameter('id'));
        UserSettingTable::instance()->updateUserEmailformatAndEmailtype($data, $request->getParameter('id'));
        isset($data['userThirdTab_street']) ? UserDataTable::instance()->updateUserAdditinalData($data, $request->getParameter('id')) : '';
        isset($data['userSecondTab_durationlength_type']) ? UserSettingTable::instance()->updateUserSettingDurationtypeAndDurationlength($data, $request->getParameter('id')) : '';
        isset($data['userFourthTab_itemsperpage']) ? UserSettingTable::instance()->updateUserSetting($data, $request->getParameter('id')) : '';
        isset($data['userSecondTab_durationlength_type']) ? $store->addUserAgent($data, $request->getParameter('id')) : '';
        isset($data['userFourthTab_itemsperpage']) ? UserWorkflowConfigurationTable::instance()->deleteSingleUserWorkflowConfigurattion($request->getParameter('id')) : '';
        isset($data['userFourthTab_itemsperpage']) ? $store->saveWorklfowSettings($data['worklfow'], $request->getParameter('id'), 1) : '';
        $this->renderText('{success:true}');
        return sfView::NONE;
    }


    /**
     * Create new user
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeSaveUser(sfWebRequest $request) {
        $store = new UserCRUD();
        $result = UserConfigurationTable::instance()->getUserConfiguration()->toArray();
        $data = $request->getPostParameters();
        $data = $store->prepareCreateData($data, $result[0]);
        $user_id = $store->saveLoginDataTab($data);
        UserSettingTable::instance()->updateUserSettingDurationtypeAndDurationlength($data, $user_id);
        UserDataTable::instance()->updateUserAdditinalData($data,$user_id);
        UserSettingTable::instance()->updateUserSetting($data,$user_id);
        $store->addUserAgent($data, $user_id);
        $store->saveWorklfowSettings($data['worklfow'], $user_id, 1);
        $this->renderText('{success:true}');
        return sfView::NONE;
    }


    /**
     * Load default system settings for creating new user.
     * 
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadDefaultData(sfWebRequest $request) {
        $result = UserConfigurationTable::instance()->getUserConfiguration()->toArray();
        $this->renderText('{"result":'.json_encode($result[0]).'}');
        return sfView::NONE;
    }

    /**
     * Load deletes users
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLoadDeletedUser(sfWebRequest $request) {
        $json_result = array();
        $usermanagement = new Usermanagement();
        $result = UserLoginTable::instance()->getDeletedUser();
        $json_result = $usermanagement->buildUser($result, 1);
        $this->renderText('{"result":'.json_encode($json_result).'}');
        return sfView::NONE;
    }


    /**
     * Activate a user, when he was deleted
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeActivateUser(sfWebRequest $request) {
        UserLoginTable::instance()->activateUserById($request->getParameter('id'));
        return sfView::NONE;
    }





}
