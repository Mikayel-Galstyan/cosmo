<?php 
/**
 * @package application_views_helpers
 */

/**
 * View helper for correcting image proportions.
 *
 * @package application_core_views_helpers
 **/
class Zend_View_Helper_Image extends Zend_View_Helper_Abstract
{
	
	/**
	 * Corrects image proportions.
	 * 
	 * Return array of width and height or null if file is not exist.
	 * 
	 * @param string $path
	 * @param string $image
	 * @param int $width
	 * @param int $height
	 * @return array|NULL
	 */
	public function correctImage ($path, $image, $width, $height) {
		if ($image && file_exists($path . $image)) {
            list($width_orig, $height_orig) = getimagesize($path . $image);
            $proportions = $width_orig/$height_orig;
            
            if ($proportions < 1) {
               $width = $height * $proportions;
            } else {
               $height = $width / $proportions;
            }
    
            return array ($width, $height);
        } else {
            return null;
        }
	}
}
 ?>