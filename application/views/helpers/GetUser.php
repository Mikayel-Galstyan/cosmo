<?php
/**
 * @package application_views_helpers 
 */

/**
 * View helper for getting information about the current user.
 *
 * @package application_views_helpers
 */
class Zend_View_Helper_GetUser extends Zend_View_Helper_Abstract {

    /**
     * Returns instance of Domain_User containing data of current user from session.
     * 
     * @return Domain_User
     */
    public function getUser(){
        $userSession = new Miqo_Session_Base();
        $user = $userSession->get('authUser');
        return $user;
    }
}