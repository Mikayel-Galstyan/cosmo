<?php
/**
 * @package library_TF_validation
 */

/**
 * The validation class for alphanumeric validation
 *
 * @package library_Miqo_validation
 */
class Miqo_Validation_AlnumAllowEmpty extends Zend_Validate_Alnum{
    
    /**
     * Checks the given item to contain only alphanumeric characters or to be empty.
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