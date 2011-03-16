<?php
/**
 * This filter adds a timestamp to usertable in column lastaction,
 * to get information, if user is online or not
 *
 * filter is deactiveted for Login module.
 *
 */
class useractionFilter extends sfFilter {

    public function execute($filterChain) {
        $user_id =  sfContext::getInstance()->getUser()->getAttribute('id');
        if($user_id != '') {
            Doctrine_Query::create()
                ->update('UserData ud')
                ->set('ud.lastaction','?',time())
                ->where('ud.user_id = ?', $user_id)
                ->execute();
        }
        $filterChain->execute();
    }

}

?>