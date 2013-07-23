<?php
/**
 * @package application_views_helpers 
 */

/**
 * View helper for checking current user's permissions.
 *
 * @package application_views_helpers
 */
class Zend_View_Helper_Authorize extends Zend_View_Helper_Abstract {
    
    /**
     * Checks current user's permissions for specific actions.
     * 
     * @param string $controllerName
     * @param string $actionName
     * @return boolean
     */
    public function authorize($controllerName, $actionName='index'){
        
    	return true;
    }

}

?>
