<?php

class Miqo_Util_Exception_Validation extends Miqo_Util_Exception_Base {
    
    private $validationErrors = null;
           
    public function __construct($errors, $message = null, $code = 0) {

        $t_message = "Exception raised in Miqo Validation Exception ";
        $t_message .= "with message : " . $message;
        
        $this->validationErrors = $errors;
        
        parent::__construct($t_message, $code);               
    }
    
    public function getValidationErrors(){
        return  $this->validationErrors;
    }    
}
