<?php
/**
 * @package application_views_helpers
 */

/**
 * View helper for setting document titles. 
 *
 * @package application_views_helpers
 */
class Zend_View_Helper_SetPageTitle extends Zend_View_Helper_Abstract {
    
    /**
     * Sets document titles.
     * 
     * @param string $keys
     * @param string $sep
     */
    public function setPageTitle($keys, $sep = ' ') {
        $key = $this->view->translate($keys, $sep);
        $script = <<<EOD
        <script>
           document.title = '$key';
        </script>
EOD;
        echo $script;
    }    
}
?>