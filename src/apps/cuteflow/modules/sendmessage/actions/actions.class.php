<?php

/**
 * sendmessage actions.
 *
 * @package    cf
 * @subpackage sendmessage
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class sendmessageActions extends sfActions {
    /**
    *
    * Executes index action
    *
    * @param sfRequest $request A request object
    */
    public function executeIndex(sfWebRequest $request) {
        $this->forward('default', 'module');
    }


    /**
     * Function sends systemmesage, and loads all sender
     * 
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeSendMail(sfWebRequest $request) {
        $subject = $request->getParameter('subject');
        $type = $request->getParameter('type');
        $content = $request->getParameter('description');
        $decission = $request->getParameter('receiver');
        switch ($decission) {
            case 'ALL':
                $users = UserLoginTable::instance()->getAllUser(-1, -1)->toArray(); // load all user
                break;
            case 'SENDER':
                $users = WorkflowTemplateTable::instance()->getWorkflowSender()->toArray(); // load sender only
                break;
            case 'ONLINE':
                $currentTime = time();
                $fiveMinutes = (1 * 60)*5;
                $fiveMinutesAgo = $currentTime - $fiveMinutes;
                $users = UserDataTable::instance()->getOnlineUser($fiveMinutesAgo)->toArray(); // user which are online for about 5mins^^
                break;
        }
        
        // send messages
        foreach($users as $user) {
            if($decission == 'SENDER') {
               $userData = new UserMailSettings($user['sender_id']);
            }
            elseif ($decission == 'ALL') {
                $userData = new UserMailSettings($user['id']);
            }
            else {
                $userData = new UserMailSettings($user['user_id']);
            }
            $send = new SendMessage();
            $send->sendSystemMail($userData, $subject, $content, $type);
        }


        $this->renderText('{success:true}');
        return sfView::NONE;
    }

}
