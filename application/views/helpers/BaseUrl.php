<?php
/**
 * @package application_views_helpers 
 */

/**
 * View helper for getting a value of 'general.url' from application.ini.
 *
 * @package application_views_helpers
 */
class Zend_View_Helper_BaseUrl extends Zend_View_Helper_Abstract {

    /**
     * Returns the value of 'general.url' from application.ini configuration file.
     * 
     * @return string
     */
    public function baseUrl() {
        $conf = Zend_Registry::get('configuration')->baseurl;
        return $conf;
    }
}