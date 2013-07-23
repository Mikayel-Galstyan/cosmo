<?php
/**
 * @package library_TF_validation
 */

/**
 * The validation class to check if file has been uploaded.
 *
 * @package library_TF_validation
 */
class Miqo_Validation_UPLOADED extends Zend_Validate_Abstract {
    /**
     * @var string
     */
    const UPLOADED = 'uploaded';
    
    /**
     * Validation message.
     *
     * @var array
     */
    protected $_messageTemplates = array(self::UPLOADED => 'Value is required and can\'t be empty ');
    
    /**
     * Checks if file has been uploaded.
     * 
     * 
     */
    public function isValid($value) {
    	$isValid = true;
    	if(!$_FILES || !$_FILES['image']["tmp_name"]){
    		$isValid = false;
    		$this->_error(self::UPLOADED);
    	}
        return $isValid;
    }
}
?>