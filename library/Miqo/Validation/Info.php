<?php
/**
 * @package library_TF_validation
 */

/**
 * The class to provide error objects.
 *
 * @package library_TF_validation
 */
class Miqo_Validation_Info {
    
    /**
     * Name of the field which have not a valid value.
     * 
     * @var string
     */
    private $fieldName;
    /**
     * The key of message translation.
     * 
     * @var string
     */
    private $key;
    /**
     * The error message given by Zend.
     * 
     * @var string
     */
    private $message;
    
    /**
     * The class constructor.
     * 
     * Initialises properties.
     * 
     * @param string $fieldName
     * @param string $key
     * @param string $message
     */
    public function __construct($fieldName = null, $key = null, $message = null) {
        $this->fieldName = $fieldName;
        $this->key = $key;
        $this->message = $message;
    }
    
    /**
     * Returns name of the field which have not a valid value.
     * 
     * @return string
     */
    public function getFieldName() {
        return $this->fieldName;
    }
    
    /**
     * Sets the name of the field which have not a valid value.
     * 
     * @param string $val
     * @return TF_Validation_Info
     */
    public function setFieldName($val) {
        $this->fieldName = $val;
        return $this;
    }
    
    /**
     * Returns key of message translation.
     * @return string
     */
    public function getKey() {
        return $this->key;
    }
    
    /**
     * Sets the key of message translation.
     *  
     * @param string $val
     * @return TF_Validation_Info
     */
    public function setKey($val) {
        $this->key = $val;
        return $this;
    }
    
    /**
     * Returns an error message given by Zend.
     * 
     * @return string
     */
    public function getMessage() {
        return $this->message;
    }
    
    /**
     * Sets an error message given by Zend.
     * 
     * @param string $val
     * @return TF_Validation_Info
     */
    public function setMessage($val) {
        $this->message= $val;
        return $this;
    }
}
?>
