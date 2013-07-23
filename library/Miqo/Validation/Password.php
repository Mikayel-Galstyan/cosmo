<?php
class Miqo_Validation_Password extends Zend_Validate_Abstract {
    /**
     * @var string
     */
    const LENGTH = 'length';
    /**
     * @var string
     */
    const UPPER  = 'upper';
    /**
     * @var string
     */
    const LOWER  = 'lower';
    /**
     * @var string
     */
    const DIGIT  = 'digit';
    /**
     * @var string
     */
    const ALNUM  = 'alnum';
    
    
    /**
     * @var array
     */
    protected $_messageTemplates = array (self::LENGTH => "Password must contain at least 6 characters in length{new_line}", self::UPPER => "Password must contain at least one uppercase letter{new_line}", self::LOWER => "Password must contain at least one lowercase letter{new_line}", self::DIGIT => "Password must contain at least one digit character{new_line}", self::ALNUM => "Password must contain only alphabetic and digit characters{new_line}");
    
    /**
     * Checks the validity of password.
     *
     * @param string $value
     * @return boolean
     */
    public function isValid($value) {
        $this->_setValue($value);
        
        $isValid = true;
        
        if (strlen($value) < 6) {
            $this->_error(self::LENGTH);
            $isValid = false;
        }
        
        if (! preg_match('/[A-Z]/', $value)) {
            $this->_error(self::UPPER);
            $isValid = false;
        }
        
        if (! preg_match('/[a-z]/', $value)) {
            $this->_error(self::LOWER);
            $isValid = false;
        }
        
        if (! preg_match('/\d/', $value)) {
            $this->_error(self::DIGIT);
            $isValid = false;
        }
        
        if (!ctype_alnum($value)) {
            $this->_error(self::ALNUM);
            $isValid = false;
        }
                
        
        return $isValid;
    }
}