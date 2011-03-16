<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usersettingclass
 *
 * @author Manu
 */
class UserSettingClass {



    public function  __construct() {

    }

    /**
     * Get first login flag of an user
     *
     * @return boolean
     */
    public static function getFirstLogin() {
        $result = UserSettingTable::instance()->getFirstLogin(sfContext::getInstance()->getUser()->getAttribute('id'))->toArray();
        return $result[0]['firstlogin'];
    }

}
?>
