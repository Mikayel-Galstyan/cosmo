<?php
/**
 * @package library_TF_validation
 */

/**
 * The class for validation of integer numbers.
 *
 * @package library_TF_validation
 */
class Miqo_Validation_DigitsAllowEmpty extends Zend_Validate_Digits{
    
    /**
     * Checks the given item to contain only digits or to be empty.
     *
     * @param int|string $value
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