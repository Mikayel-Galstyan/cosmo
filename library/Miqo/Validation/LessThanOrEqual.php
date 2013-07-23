<?php
/**
 * @package library_TF_validation
 */

/**
 * The validation class to compare 2 numbers.
 *
 * @package library_TF_validation
 */
class Miqo_Validation_LessThanOrEqual extends Zend_Validate_LessThan {
    /**
     * @var string
     */
    const LESS_THAN_OR_EQUAL = 'lessThanOrEqual';
    
    /**
     * Validation message.
     *
     * @var array
     */
    protected $_messageTemplates = array (self::LESS_THAN_OR_EQUAL => "'%value%' is not less than or equal to '%max%'");
    
    /**
     * Checks whether value less than or equal to given maximum value.
     * 
     * @param float $value
     * @return boolean
     */
    public function isValid($value) {
        $isValid =  parent::isValid($value-1);
        $this->_setValue($value);
        $this->_error(self::LESS_THAN_OR_EQUAL);
        
        return $isValid;
    }
}