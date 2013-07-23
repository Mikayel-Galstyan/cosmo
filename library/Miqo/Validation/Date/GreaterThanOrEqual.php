<?php
/**
 * @package library_TF_validation_date
 */

/**
 * The validation class to compare Zend_Date objects.
 *
 * @package library_TF_validation_date
 */
class Miqo_Validation_Date_GreaterThanOrEqual extends Zend_Validate_Abstract {    
    /**
     * @var string
     */
    const DATE_GREATER_THAN_OR_EQUAL = 'greaterThanOrEqual';
    
    /**
     * Validation message.
     * 
     * @var array
     */
    protected $_messageTemplates = array (self::DATE_GREATER_THAN_OR_EQUAL =>'End date must be greater than or equal to start date');    
    /**
     * @var Miqo_Util_Date
     */
    private $minDate;
    
    /**
     * Checks whether value(date) greater than or equal to the given date.
     * 
     * @param Miqo_Util_Date $value
     * @return boolean
     */
    public function isValid($value) { 
        $this->_setValue($value);
        if($this->minDate instanceof Miqo_Util_Date && $value instanceof Miqo_Util_Date) {
            if($value < $this->minDate) {
                $this->_error(self::DATE_GREATER_THAN_OR_EQUAL);
                return false;
            }
        }
        return true;
    }
    
    /**
     * Sets the date to compare with.
     *
     * @param  Miqo_Util_Date $minDate
     * @return Miqo_Validation_Date_GreaterThanOrEqual
     */
    public function setMinDate($minDate) {
        $this->minDate = $minDate;
        return $this;
    }
}
?>