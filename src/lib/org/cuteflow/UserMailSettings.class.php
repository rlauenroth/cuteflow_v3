<?php

class UserMailSettings {

    public $user_id;
    public $userSettings;
    public $userData;

    public function  __construct($user_id) {
        $this->user_id = $user_id;
        $this->setData();

    }


    public function setData() {
        $userSettings = UserSettingTable::instance()->getUserSettingById($this->user_id)->toArray();
        $replayAdress = EmailConfigurationTable::instance()->getEmailConfiguration()->toArray();
        $userLogin = UserLoginTable::instance()->findActiveUserById($this->user_id);
        $userData = UserDataTable::instance()->getUserDataByUserId($this->user_id)->toArray();
        $this->userSettings = $userSettings[0];
        $this->userSettings['systemreplyaddress'] = $replayAdress[0]['systemreplyaddress'];
        $this->userData['username'] = $userLogin[0]->getUsername();
        $this->userData['user_id'] = $userLogin[0]->getId();
        $this->userData['email'] = $userLogin[0]->getEmail();
        $this->userData['firstname'] = $userData[0]['firstname'];
        $this->userData['lastname'] = $userData[0]['lastname'];
    }

}
?>