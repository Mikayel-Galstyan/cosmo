<?php
/**
 * @package library_Miqo_validation
 */

/**
 * The base class for validators.
 *
 * @package library_Miqo_validation
 */
class Miqo_Validation_Base {
    
    // Validator constant names
    /**
     * @var string
     */
    const NOT_EMPTY = 'notEmpty';
    /**
     * @var string
     */
    const STRING_LENGTH = 'stringLength';
    /**
     * @var string
     */
    const EMAIL_ADDRESS = 'email';
    /**
     * @var string
     */
    const EMAIL_ADDRESS_ALLOW_EMPTY = 'emailAllowEmpty';
    /**
     * @var string
     */
    const BETWEEN = 'between';
    /**
     * @var string
     */
    const GREATER_THAN = 'greater';
    /**
     * @var string
     */
    const LESS_THAN = 'less';
    /**
     * @var string
     */
    const LESS_THAN_OR_EQUAL = 'lessThanOrEqual '; 
    /**
     * @var string
     */
    const ALNUM = 'alnum';
    /**
     * @var string
     */
    const ALNUM_ALLOW_EMPTY = 'alnumAllowEmpty';
    /**
     * @var string
     */
    const REGEX = 'regex';
    /**
     * @var string
     */
    const DB_NO_RECORD_EXISTS = 'dbRecordExists';
    /**
     * @var string
     */
    const DIGITS = 'digits';
    /**
     * @var string
     */
    const DIGITS_ALLOW_EMPTY = 'digitsAllowEmpty';
    /**
     * @var string
     */
    const FLOAT = 'float';
    /**
     * @var string
     */
    const FLOAT_ALLOW_EMPTY = 'floatAllowEmpty';
    /**
     * @var string
     */
    const PASSWORD = 'password';
    /**
     * @var string
     */
    const DATE_GREATER_THAN_OR_EQUAL = 'DateGreaterThanOrEqual';
    /**
     * @var string
     */
    const UPLOADED = 'uploaded';
    
    /**
     * @var array
     */
    private $validators = array ();
    /**
     * @var array
     */
    private $confArray = null;
    /**
     * @var array
     */
    private $defaults = array(
            'min'=> '0',
            'max'=>'100',
            'inclusive' => true,
            'encoding' => 'UTF-8',
            'allowWhiteSpace'=> true,
            'pattern' => null
            );   
    
    /**
     * Applies some configurations.
     * 
     * The class constructor.
     * 
     * @param array $confArray
     */
    public function __construct($confArray) {
        $this->confArray = $confArray;
    }
    
    /**
     * Validates Domain entity by defined validations and returns an information about the validations.
     * 
     * @param Miqo_Domain_AbstractEntity $domainEntity
     * @return array
     */
    public function validate($domainEntity) {
        $messages = array ();
        $className = str_replace('Domain_', '',get_class($domainEntity));
        foreach ( $this->confArray as $filedName => $validationDefs ) {            
            foreach ( $validationDefs as $validatorName => $options ) {                
                if (is_numeric($validatorName)) {
                    $validatorName = $options;
                    $options = array();
                }                
                $validator = $this->createValidator($validatorName, $options);
                $methodGet = 'get' . ucfirst($filedName);                
                if (!$validator->isValid($domainEntity->$methodGet())) {                   
                    $key = 'validation.' . strtolower($className) . '.' . $filedName . '.' . $validatorName;
                    $messages[] = new Miqo_Validation_Info($filedName, $key, $validator->getMessages());
                    break;
                }                
            }
            
        }       
        return $messages;
    }
    
    /**
     * Sets some configurations.
     * 
     * @param array $confArray
     * @return void
     */
    public function setConf($confArray) {
        $this->confArray = $confArray;
    }
    
    /**
     * Creates an object of validator with the given options.
     * 
     * @param string $validatorName
     * @param array $options
     * @return Zend_Validate_Abstract
     */
    private function createValidator($validatorName, $options = array()) {  
        $mergedOptions = array_merge($this->defaults, $options);     
        $key = strtolower($validatorName);
        if (! array_key_exists($key, $this->validators)) {
            switch ($validatorName) {
                case self::NOT_EMPTY:
                    $validator = new Zend_Validate_NotEmpty();
                    break;
                case self::STRING_LENGTH:
                    $validator = new Zend_Validate_StringLength($mergedOptions['min'], $mergedOptions['max'], $mergedOptions['encoding']);                   
                    break;
                case self::EMAIL_ADDRESS :
                    $validator = new Zend_Validate_EmailAddress();
                    break;   
                case self::EMAIL_ADDRESS_ALLOW_EMPTY :
                    $validator = new Miqo_Validation_EmailAddressAllowEmpty();
                    break;                
                case self::BETWEEN:
                    $validator = new Zend_Validate_Between($mergedOptions['min'], $mergedOptions['max'], $mergedOptions['inclusive']);
                    break;
                case self::GREATER_THAN:
                    $validator = new Zend_Validate_GreaterThan($mergedOptions['min']);
                    break;
                case self::LESS_THAN:
                    $validator = new Zend_Validate_LessThan($mergedOptions['max']);
                    break;
                case self::LESS_THAN_OR_EQUAL:
                    $validator = new  Miqo_Validation_LessThanOrEqual($mergedOptions['max']);
                    break;
                case self::ALNUM: 
                    $validator = new Zend_Validate_Alnum($mergedOptions['allowWhiteSpace']);
                    break;
                case self::ALNUM_ALLOW_EMPTY :
                    $validator = new Miqo_Validation_AlnumAllowEmpty();
                    break;
                case self::REGEX:
                    $validator = new Zend_Validate_Regex($mergedOptions['pattern']);
                    break;
                case self::DB_NO_RECORD_EXISTS:                                       
                    $validator = new Zend_Validate_Db_NoRecordExists($mergedOptions['table'], $mergedOptions['field']);                    
                    break;
                case self::DIGITS :
                    $validator = new Zend_Validate_Digits();
                    break;                    
                case self::DIGITS_ALLOW_EMPTY :
                    $validator = new Miqo_Validation_DigitsAllowEmpty();
                    break;
                case self::FLOAT :
                	$validator = new Zend_Validate_Float();
                	break;
            	case self::FLOAT_ALLOW_EMPTY :
            		$validator = new Miqo_Validation_FloatAllowEmpty();
            		break;
                case self::PASSWORD:
                    $validator = new Miqo_Validation_Password();
                    break;
                case self::DATE_GREATER_THAN_OR_EQUAL:
                    $validator = new Miqo_Validation_Date_GreaterThanOrEqual($mergedOptions['minDate']);
                    break;
                case self::UPLOADED:
                        $validator = new Miqo_Validation_Uploaded();
                        break;
                default:    
                    $validatorName = 'Zend_Validate_'.$validatorName;
                    $validator  = new $validatorName($mergedOptions['table']);
                    break;
            }
            $this->validators [$key] = $validator;
        }
        $validator = $this->validators [$key];

        if ($validatorName != self::DB_NO_RECORD_EXISTS){
            foreach ($options as $key => $value){
                $methodSet = 'set'.ucfirst($key);
                $validator->$methodSet($value);
            }
        }                
        return $validator;
    }
}
?>