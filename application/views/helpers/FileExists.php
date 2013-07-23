<?php
/**
 * @package application_views_helpers 
 */

/**
 * View helper for checking whether the logo image exists or no.
 *
 * @package application_core_views_helpers
 **/
class Zend_View_Helper_FileExists extends Zend_View_Helper_Abstract {

    /**
     * Checks whether the logo image exists or no.
     * 
     * Returns true if file exists and false in the other case.
     * 
     * @param string $fileName
     * @return boolean
     */
    public function fileExists($folder, $name){
        $path = APPLICATION_PATH . '/data/uploads/' . $folder; 
        $file = $path.'/'.$name;               
        if(file_exists($file) && is_file($file)){
            return true;
        }                
        return false;
    }
}

?>
