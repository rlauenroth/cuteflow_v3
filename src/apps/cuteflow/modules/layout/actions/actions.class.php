<?php

/**
* layout actions.
*
* @package    cf
* @subpackage layout
* @author     Your name here
* @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
*/
class layoutActions extends sfActions {
    /**
     *
    * Load Userrights and User Id to Sesseion.
    *
    * @param sfRequest $request A request object
    */
    public function executeIndex(sfWebRequest $request) {
        $loginObject = new Login();
        
        /*
        * Load the userrole, userrigths, userSettings, userId, workflowSettings for the logged user and store to session
        */
        $userSettings = UserSettingTable::instance()->getUserSettingById($this->getUser()->getAttribute('id'));
        $userWorkflowSetting = UserWorkflowConfigurationTable::instance()->getSingleUserWorkflowConfigurattion($this->getUser()->getAttribute('id'))->toArray();
        $this->getUser()->setAttribute('userSettings', $userSettings[0]->toArray()); // set userSettings
        $config = SystemConfigurationTable::instance()->getSystemConfiguration()->toArray();
        $this->getUser()->setAttribute('userWorkflowSettings', $loginObject->generateUserWorklowView($userWorkflowSetting, sfContext::getInstance())); // set workflowsettings
        $data = $this->getUser()->getAttribute('userWorkflowSettings');
        $credentials = CredentialTable::instance()->getAllCredentials();
        $userrights = CredentialRoleTable::instance()->getCredentialRoleById($this->getUser()->getAttribute('id'));
        $rights = $loginObject->loadUserRight($credentials, $userrights);
        $this->getUser()->setAttribute('credential', $rights); // set rights and role
        $this->systemConfiguration = $config[0];
        $this->theTheme = $userSettings[0]->getTheme(); // load the users theme
        /*
         * -1 is set when user uses login form to login
         * int is set, when user logges in from en email link, then a workflow needs to opened
         */
        $this->version_id  = $request->getParameter('versionid',-1);
        $this->workflow_id  = $request->getParameter('workflow',-1);
        $this->window  = $request->getParameter('window',-1);
        return sfView::SUCCESS;
    }

    /**
     * Sets firstlogin to 0
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeChangeFirstLogin(sfWebRequest $request) {
        UserSettingTable::instance()->setFirstLogin($this->getUser()->getAttribute('id'));
        return sfView::NONE;
    }


    /**
     * Check if the session is still active
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeCheckSession(sfWebRequest $request) {
        if($this->getUser()->hasAttribute('id')) {
            $result = 1;
        }
        else {
            $result = 0;
        }
        $this->renderText('{"result":'.$result.'}');
        return sfView::NONE;
    }

   


    /**
     * Function allows LinkLogin by an email and redirects to the needed actions
     * the redirect depends on systemsettings. it allows direct linklogin without authentication using loginmask
     * other possibility is, if no session is set using emaillogin, loginmask is shown and user needs to login
     * to fill the workflow
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeLinklogin(sfWebRequest $request) {

        $settings = AuthenticationConfigurationTable::instance()->getAuthenticationConfiguration()->toArray();
        $user_id = $request->getParameter('userid');
        if($settings[0]['allowdirectlogin'] == 1) { // allow direct login, without using login form
            $userLogin = UserLoginTable::instance()->findUserById($user_id);
            $arr = $userLogin->toArray(); // load User Data
            if($this->getUser()->isAuthenticated() == false) { // check if user is already logged in
                if(empty($arr) == false) { // a user has been found, -> user is not deleted
                    $settings = UserSettingTable::instance()->getUserSettingById($user_id); // user is not logged in, set the settings
                    $this->getUser()->setAuthenticated(true);
                    $this->getUser()->setAttribute('id',$user_id);
                    $this->getUser()->setAttribute('userrole',$userLogin[0]->getRoleId());
                    $this->getUser()->setCulture($settings[0]->getLanguage());
                    $this->getUser()->setAttribute('env', str_replace('/', '', $request->getScriptName()));
                    $this->redirect($this->generateUrl('default', array('module' => 'layout', 'action' => 'index', 'versionid' => $request->getParameter('versionid'), 'workflow' => $request->getParameter('workflowid'), 'window' => $request->getParameter('window'))));
                }
                else { // user is not found or is deleted
                    $this->redirect('login/index');
                }
            }
            else { // user is already logged in
                $this->redirect($this->generateUrl('default', array('module' => 'layout', 'action' => 'index', 'versionid' => $request->getParameter('versionid'), 'workflow' => $request->getParameter('workflowid'), 'window' => $request->getParameter('window'))));
            }
        }
        else { // allow direct login is denied
            if($this->getUser()->isAuthenticated() == true) { // user is already logged in
                $this->redirect($this->generateUrl('default', array('module' => 'layout', 'action' => 'index', 'versionid' => $request->getParameter('versionid'), 'workflow' => $request->getParameter('workflowid'), 'window' => $request->getParameter('window'))));
            }
            else { // move to login page
                $this->redirect($this->generateUrl('default', array('module' => 'login', 'action' => 'index', 'versionid' => $request->getParameter('versionid'), 'workflow' => $request->getParameter('workflowid'), 'window' => $request->getParameter('window'))));
            }
        }
        return sfView::NONE;
    }
}