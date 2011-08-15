<?php

class MergeAuthorization {

    /**
     *
     *  Function merges the rights for the mailinglist auth tab
     *
     * @param array $allRoles, alls rolles in the system
     * @param array $defaultAuth
     * @param array $auth
     * @return <type>
     */
    public function mergeRoles(array $allRoles, array $defaultAuth, array $auth) {
        foreach($allRoles as $singleRole) {
            $write = true;
            foreach($auth as $exists) {
                if ($singleRole['description'] == $exists['type'] 
                        || $singleRole['description'] == 'admin' 
                        || $singleRole['description'] == 'sender' 
                        || $singleRole['description'] == 'receiver') {
                    $write = false;
                    break;
                }
            }
            if ($write) {
                $lastArr = count($auth);
                $auth[$lastArr]['type'] = $singleRole['description'];
                $auth[$lastArr]['raw_type'] = $singleRole['description'];
                $auth[$lastArr]['id'] = -1;
                $auth[$lastArr]['isRole'] = true;
                $auth[$lastArr]['roleId'] = $singleRole['id'];
                $auth[$lastArr]['delete_workflow'] = $defaultAuth[0]['delete_workflow'];
                $auth[$lastArr]['archive_workflow'] = $defaultAuth[0]['archive_workflow'];
                $auth[$lastArr]['stop_new_workflow'] = $defaultAuth[0]['stop_new_workflow'];
                $auth[$lastArr]['details_workflow'] = $defaultAuth[0]['details_workflow'];
            }

        }
        return $auth;
    }

    


}
?>
