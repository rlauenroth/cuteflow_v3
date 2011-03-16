<?php

/**
* userrolemanagement actions.
*
* @package    cf
* @subpackage userrolemanagement
* @author     Manuel Schaefer
* @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
*/

class userrolemanagementActions extends sfActions {



    /**
    *
    * Function loads all Roles for the Grid.
    * Actually no Filter and Paging is needed
    *
    * @param sfWebRequest $request
    * @return <type>
    */
    public function executeLoadAllRoles(sfWebRequest $request) {
        $userrolemanagement = new UserRolemanagement();
        $result = RoleTable::instance()->getAllRoleWithUser();
        $json_result = $userrolemanagement->buildRole($result, 1);

        $this->renderText('({"result":'.json_encode($json_result).'})');
        return sfView::NONE;
    }


    /**
    * Function loads all roles for the pop 'Delete Role'.
    * The Role, user want to delete is not loaded
    *
    * @param sfWebRequest $request
    * @return <type>
    */
    public function executeLoadDeletableRoles(sfWebRequest $request){
        $userrolemanagement = new UserRolemanagement();
        $result = RoleTable::instance()->getAllRole($request->getParameter('id'));
        $json_result = $userrolemanagement->buildRoleCombobox($result);
        $this->renderText('({"result":'.json_encode($json_result).'})');
        return sfView::NONE;
    }

   
    /**
    *
    * Function Deletes a Role, and sets all users of the deleted Role
    * to the selected Role from Combobox
    *
    * @param sfWebRequest $request
    * @return <type>
    */
    public function executeDeleteRole(sfWebRequest $request) {
        
        $rows = UserLoginTable::instance()->changeRole($request->getParameter('updateid'),$request->getParameter('deleteid'));
        CredentialRoleTable::instance()->deleteRoleById($request->getParameter('deleteid'));
        RoleTable::instance()->deleteRole($request->getParameter('deleteid'));
        $this->renderText($rows);
        return sfView::NONE;
    }


    /**
    * Function builds the Tabs, Groups and Rights for the Pop 'Add Role' and 'Edit Role'
    *
    * @param sfWebRequest $request
    * @return <type>
    */
    public function executeLoadRoleTree(sfWebRequest $request) {
        $credentialmanagement = new CredentialRolemanagement();
        $credentials = NULL;
        // when in editmode, load additinaldata
        if ($request->getParameter('role_id') != '') {
            // available rights for role
            $res =  CredentialRoleTable::instance()->getCredentialById($request->getParameter('role_id'));
            $credentials = $credentialmanagement->buildCredentials($res);
            $roleName = RoleTable::instance()->getRoleById($request->getParameter('role_id'));
        }

        $result = CredentialTable::instance()->getAllCredentials('c.usermodule asc,c.usergroup asc');
        $credentialmanagement->setRecords($result);
        $credentialmanagement->setContext($this->getContext());
        $json_result = $credentialmanagement->buildTree($credentials);

        if ($request->getParameter('role_id') != '') {
           $this->renderText('{"result":'.json_encode($json_result).',"name":"'.$roleName[0]->getDescription().'"}');
        }
        else {
           $this->renderText('{"result":'.json_encode($json_result).',"name":""}');
        }
        return sfView::NONE;
    }


    /**
    * Function checks, when user is trying to create a new userrole , if its
    * name is already stored in database.
    * When already stored, no save process is done.
    *
    *
    * @param sfWebRequest $request
    * @return <type>
    */
    public function executeCheckForExistingRole(sfWebRequest $request)  {
        $result = RoleTable::instance()->getRoleByDescription($request->getParameter('description'));
        
        if($result[0]->getDescription() == $request->getParameter('description')) {
            $this->renderText('0'); // no write access
        }
        else {
            $this->renderText('1'); // write access
        }
        return sfView::NONE;
    }




    /**
    * Function adds a role to database
    *
    * @param sfWebRequest $request
    * @return <type>
    */
    public function executeAddRole(sfWebRequest $request) {
        $data = $request->getPostParameters();
        if(count($data) > 2) { // some rights are set
            unset($data['userrole_title_name']);
            unset($data['hiddenfield']);
            $values = array_keys($data);

            $roleObj = new Role();
            $roleObj->setDescription($request->getParameter('userrole_title_name'));
            $roleObj->save();
            $id = $roleObj->getId();

            foreach($values as $item) {
                $rolecredObj = new CredentialRole();
                $rolecredObj->setRoleId($id);
                $rolecredObj->setCredentialId($item);
                $rolecredObj->save();
            }
        }
        else { // Only Userrole is written in textfield, nothing else
            $obj = new Role();
            $obj->setDescription($request->getParameter('userrole_title_name'));
            $obj->save();
        }
        $this->renderText('{success:true}');
        return sfView::NONE;
    }


    /**
    * Changes an Edited Role
    *
    * @param sfWebRequest $request
    * @return <type>
    */
    public function executeEditRole(sfWebRequest $request) {
        $data = $request->getPostParameters();
        CredentialRoleTable::instance()->deleteCredentialRole($this->getRequestParameter('hiddenfield'));
        unset($data['hiddenfield']);
        $values = array_keys($data);
        foreach($values as $item) {
            $rolecredObj = new CredentialRole();
            $rolecredObj->setRoleId($this->getRequestParameter('hiddenfield'));
            $rolecredObj->setCredentialId($item);
            $rolecredObj->save();
        }
        $this->renderText('{success:true}');
        return sfView::NONE;
    }


  
}
