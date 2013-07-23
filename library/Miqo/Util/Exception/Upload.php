<?php

class Miqo_Util_Exception_Upload extends Miqo_Util_Exception_Base {
    
   public function __construct($message = null, $code = 0) {

      $t_message = "Exception raised in Miqo Upload Exception ";
      $t_message .= "with message : " . $message;

      parent::__construct($t_message, $code);

   }    
    
}