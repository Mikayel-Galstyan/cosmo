<?php
/**
 * @package application_views_helpers 
 */

/**
 * View helper for getting a current language of the project.
 *
 * @package application_views_helpers
 */
class Zend_View_Helper_GetLang extends Zend_View_Helper_Abstract {

    /**
     * Returns current language of the project.
     *
     * @return string
     */
    public function getLang() {
        $langSession = new Zend_Session_Namespace('lang');
        return $langSession->lang;
    }
}

