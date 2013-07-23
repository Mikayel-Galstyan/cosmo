<?php
/**
 * @package library_TF_validation
 */

/**
 * The class for validation of email addresses.
 *
 * @package library_TF_validation
 */
class Miqo_Validation_EmailAddressAllowEmpty extends Zend_Validate_EmailAddress{
    
    /**
     * Checks the given item to look like a valid email address.
     *
     * @param string $value
     * @return boolean
     */
    public function isValid($value) {
        $this->_setValue($value);
    
        $isValid = true;
    
        if (!empty($value)) {
            return parent::isValid($value);
        }               
    
        return $isValid;
    }
}