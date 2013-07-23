<?php
/**
 * @package library_TF_validation
 */

/**
 * The class for validation of float numbers.
 *
 * @package library_TF_validation
 */
class Miqo_Validation_FloatAllowEmpty extends Zend_Validate_Float{
    
    /**
     * Checks the given item to be a float number or empty.
     *
     * @param string|float $value
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