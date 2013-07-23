<?php
/**
 * @package application_views_helpers
 */

/**
 * View helper for translating strings.
 *
 * @package application_core_views_helpers
 **/

class Zend_View_Helper_Translate extends Zend_View_Helper_Abstract {

    /**
     * Looks up in the translation keys.
     * 
     * If the $key is found returns the value of it, otherwise returns the $key.
     * 
     * @param string $keys
     * @param string $sep
     */
    public function translate($keys, $sep = ' ') {
        $translation = Zend_Registry::get('translate');
        if (is_array($keys)) {
            $transKey = '';
            foreach ( $keys as $key ) {
                $transKey .= $sep . $translation->translate($key);
            }            
            return substr($transKey, strlen($sep));
        } else {
            return $translation->translate($keys);
        }
    }
}

