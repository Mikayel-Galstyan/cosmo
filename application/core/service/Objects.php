<?php

class Service_Objects extends Miqo_Service_Base {
    private $validator = null;
    private static $VALIDATION_CONFIG = array (
            'path' => array (Miqo_Validation_Base::NOT_EMPTY),
            'objectTypeId' => array (Miqo_Validation_Base::NOT_EMPTY),
            'cost' => array (Miqo_Validation_Base::NOT_EMPTY),
            'publisherId' => array (Miqo_Validation_Base::NOT_EMPTY),
    );

    
    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Objects();
    }
    
    public function getByParams(Filter_Objects $filter){
        $items = $this->dao->getByParams($filter);
        return $items;
    }
    
    public function &__t_save(Domain_Objects $domain) {
        $errors = $this->validate($domain);       
        if (sizeof($errors) == 0) {   
            $domain = $this->dao->save($domain);
            return $domain;
        } else {
            throw new Miqo_Util_Exception_Validation($errors, "save.of.user.is.suspended.as.there.are.validation.errors");
        }
    }
    
    public function validate(Domain_Objects $domain) {
        $validationConf = self::$VALIDATION_CONFIG;
        if ($this->validator == null) {
            $this->validator = new Miqo_Validation_Base($validationConf);
        }
        $errors = $this->validator->validate($domain);                   
        return $errors;
    }  
    

}
?>