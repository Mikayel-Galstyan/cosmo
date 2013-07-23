<?php
/**
 * @package application_views_helpers 
 */

/**
 * View helper for escaping characters with special significances in HTML.
 *
 * @package application_views_helpers
 */
class Zend_View_Helper_HtmlEscape extends Zend_View_Helper_Abstract {
    
    /**
     * Escapes characters with special significances in HTML.
     * 
     * @param string $text
     * @return string
     */
    public function htmlEscape($text) {
        return htmlspecialchars($text);
    }
}
?>