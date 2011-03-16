<?php
class PrepareReminderEmail {

    public function  __construct() {


    }


    /**
     * Checks for each worklow, that a userid is only entered one time.
     *
     * @param array $data, workflow data
     * @return array $result, data sorted by workflow, that contains all DISTINCT users
     */
    public function prepareData(array $data) {
        $result = array();
        $a = 0;
        $start = true;
        foreach($data as $user) {
            if($start == true) {
                $result[$a]['user_id'] = $user['user_id'];
                $start = false;
                $a++;
            }
            else {
                if($user['user_id'] != $result[$a-1]['user_id']) {
                    $result[$a]['user_id'] = $user['user_id'];
                    $a++;
                }

            }
        }
        return $result;
    }


    /**
     *
     * @param array $data, Workflow with all users who are WAITING
     * @return array $result, user and its open worklfows
     */
    public function sortByUser(array $data) {
        $result = array();
        $a = 0;
        $start = true;
        $b = 0;
        $arrayToCheck = array();
        foreach($data as $workflow) {
            foreach($workflow['users'] as $user) {
                if($start == true) {
                    $arrayToCheck[$a] = $user['user_id'];
                    $result[$a]['user_id'] = $user['user_id'];
                    $result[$a]['workflows'][$b]['workflow_id'] = $workflow['workflow_id'];
                    $result[$a]['workflows'][$b]['workflowversion_id'] = $workflow['workflowversion_id'];
                    $result[$a]['workflows'][$b]['name'] = $workflow['name'];
                    $a++;
                }
                else {
                    $needle = array_search($user['user_id'], $arrayToCheck);
                    if($needle === false) {
                        $arrayToCheck[$a] = $user['user_id'];
                        $result[$a]['user_id'] = $user['user_id'];
                        $result[$a]['workflows'][$b]['workflow_id'] = $workflow['workflow_id'];
                        $result[$a]['workflows'][$b]['workflowversion_id'] = $workflow['workflowversion_id'];
                        $result[$a]['workflows'][$b]['name'] = $workflow['name'];
                        $a++;
                    }
                    else {
                        $b++;
                        $result[$needle]['workflows'][$b]['workflow_id'] = $workflow['workflow_id'];
                        $result[$needle]['workflows'][$b]['workflowversion_id'] = $workflow['workflowversion_id'];
                        $result[$needle]['workflows'][$b]['name'] = $workflow['name'];
                    }
                }
                $start = false;
            }
        }
        return $result;
    }


}


?>