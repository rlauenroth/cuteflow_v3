<?php

/**
 * Function loads auth for a user, if he has right to load details or delete a workflow
 */
class CreateWorkflowAuthorizationRights {

    public $defaultRole;
    public $userroleName;
    public $userId;

    public function  __construct() {
        
    }

    /**
     * Set the default role settings
     */
    public function setDefaultRole() {
        $roles = AuthorizationConfigurationTable::instance()->getAllRoles()->toArray();
        $this->defaultRole = $roles[0];
    }

    /**
     * Load the rolename for the logged user
     *
     * @param int $userId
     */
    public function setUserRole($userId) {
        $role = RoleTable::instance()->getRoleByUserId($userId)->toArray();
        $this->userroleName = $role[0]['description'];
        $this->userId = $userId;
    }


    /**
     *
     * Function checks all rights for the user
     *
     * @param int $mailinglistVersionId, id of the mailinglist version
     * @param int $workflowversionid, id of the workflowversion
     * @return array $result, array with the rights
     */
    public function getRights($mailinglistVersionId, $workflowversionid) {
        $roleCheck = $this->checkRole($mailinglistVersionId); // checks if the role of the user, is appearing in the mailinglist auth settings. if not, default settings are loaded
        $allowedSenderCheck = $this->checkAllowedSender($mailinglistVersionId);
        $sendingRight = $this->checkSendingRight($mailinglistVersionId);
        $receiver = $this->checkReceiver($workflowversionid, $mailinglistVersionId);
        $result['deleteworkflow'] = $this->mergeRights($roleCheck, $allowedSenderCheck, $sendingRight, $receiver, 'deleteworkflow');
        $result['archiveworkflow'] = $this->mergeRights($roleCheck, $allowedSenderCheck, $sendingRight, $receiver, 'archiveworkflow');
        $result['stopneworkflow'] = $this->mergeRights($roleCheck, $allowedSenderCheck, $sendingRight, $receiver, 'stopneworkflow');
        $result['detailsworkflow'] = $this->mergeRights($roleCheck, $allowedSenderCheck, $sendingRight, $receiver, 'detailsworkflow');
        return $result;
    }


    /**
     *
     * @param array $roles, the role of the user, with the sending rights for delete, archive, stop, details
     * @param array $allowedsender, user is allowed to send workflows
     * @param array $sendingRight, user has sendingrights
     * @param array $receiver, user is a receiver
     * @param string $offset, offset can be delete, archive stopnew or detailsworkflow
     * @return <type>
     */
    public function mergeRights(array $roles, array $allowedsender, array $sendingRight, array $receiver, $offset) {
        $result = array();
        
        $value = $roles[$offset];
        if($allowedsender['allowedtosend'] == 1) {
            if($value != 1) {
                $value = $roles[$offset];
            }

        }
        if($sendingRight['allowedtosend'] == 1) {
            if($value != 1) {
                $value = $roles[$offset];
            }
        }
        if($receiver['allowedtosend'] == 1) {
            if($value != 1) {
                $value = $roles[$offset];
            }
        }
       return $value;
    }

    /**
     *
     * Check if the user is in the receiverslist of the workflow
     *
     * @param int $workflowversionId, id of the workflow
     * @param int $mailinglistVersionId, id of the mailinglist
     * @return boolean
     */
    public function checkReceiver($workflowversionId, $mailinglistVersionId) {
        $receiver = WorkflowSlotUserTable::instance()->getUserByWorkflowVersionId($this->userId, $workflowversionId)->toArray();
        if(empty($receiver) == true) {
            $result['allowedtosend'] = 0;
            return $result;
        }
        else {
            $sender = MailinglistAuthorizationSettingTable::instance()->getSettingsByType('receiver', $mailinglistVersionId)->toArray();
            $sender[0]['allowedtosend'] = 1;
            return $sender[0];
        }
        
    }


    /**
     *
     * Check if the user has sending rights
     *
     * @param int $mailinglistVersionId
     * @return boolean
     */
    public function checkSendingRight($mailinglistVersionId) {
        
        $credentialId = CredentialTable::instance()->getCredentialIdByRight('workflow','workflowmanagement','sendWorkflow')->toArray();
        $rightCheck = RoleTable::instance()->getRoleByRightAndRoleName($credentialId[0]['id'], $this->userroleName)->toArray();
        if(empty($rightCheck) == true) {
            $result['allowedtosend'] = 0;
            return $result;
        }
        else {
            $sender = MailinglistAuthorizationSettingTable::instance()->getSettingsByType('senderwithrights', $mailinglistVersionId)->toArray();
            $sender[0]['allowedtosend'] = 1;
            return $sender[0];
        }
        
    }

    /**
     * Check if the user can use the mailinglist to create a workflow
     *
     * @param int $mailinglistVersionId
     * @return boolean
     */
    public function checkAllowedSender($mailinglistVersionId) {
        $allowedsender = MailinglistAllowedSenderTable::instance()->getAllowedSenderByMailinglistIdAndUserId($this->userId, $mailinglistVersionId)->toArray();
        if(empty($allowedsender) == true) {
            $result['allowedtosend'] = 0;
            return $result;
        }
        else {
            $sender = MailinglistAuthorizationSettingTable::instance()->getSettingsByType('allowedsender', $mailinglistVersionId)->toArray();
            $sender[0]['allowedtosend'] = 1;
            return $sender[0];
        }
    }


    /**
     *
     * Check if the role of the user, is exisiting in the mailinglist, if not default role is returend, else
     * the usersrole is returned
     *
     * @param <type> $mailinglistVersionId
     * @return <type>
     */
    public function checkRole($mailinglistVersionId) {
        $rights = MailinglistAuthorizationSettingTable::instance()->getSettingsByType($this->userroleName, $mailinglistVersionId)->toArray();
        if(empty($rights) == true) {
            return $this->defaultRole;
        }
        else {
            return $rights[0];
        }
    }


    






}
?>
