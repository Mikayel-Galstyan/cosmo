<?php
/**
 * @package application_views_helpers 
 */

/**
 * View helper for javascript redirection.
 *
 * @package application_views_helpers
 */
class Zend_View_Helper_Js extends Zend_View_Helper_Abstract {

    /**
     * Redirects by specified URL address.
     * 
     * @param string $url
     */
    public function redirect($url) {
        $script = <<<EOD
        <script>
            window.location = '$url'        
        </script>
EOD;
        echo $script;
    }
    
    /**
     * Checks url and removes hash tag if found.
     */
    public function urlChecker() {
        $script = <<<EOD
        <script>
            if(window.location.hash) {
        	    value = window.location.hash.substring(1);
        	    window.location = value;          	
            } 
        </script>
EOD;
        echo $script;
    }   
}
?>