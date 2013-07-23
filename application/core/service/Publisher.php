<?php

class Service_Publisher extends Miqo_Service_Base {
    private $validator = null;
    private static $VALIDATION_CONFIG = array (
            'name' => array (Miqo_Validation_Base::NOT_EMPTY, Miqo_Validation_Base::DB_NO_RECORD_EXISTS => array('table'=>Dao_DbTable_List::PUBLISHER, 'field' => 'name')),
    );
    
    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Publisher();
    }
    
    public function &__t_save(Domain_Publisher $domain) { 
        $errors = $this->validate($domain);       
        if (sizeof($errors) == 0) {                     
            $domain = $this->dao->save($domain);
            return $domain;
        } else {
            throw new Miqo_Util_Exception_Validation($errors, "save.of.user.is.suspended.as.there.are.validation.errors");
        }
    }
    
     public function validate(Domain_Publisher $domain) {
        $validationConf = self::$VALIDATION_CONFIG;
        if ($this->validator == null) {
            $this->validator = new Miqo_Validation_Base($validationConf);
        }
        $errors = $this->validator->validate($domain);                   
        return $errors;
    }  
   
   
}
?>
