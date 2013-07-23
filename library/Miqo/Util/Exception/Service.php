<?php

class Miqo_Util_Exception_Service extends Miqo_Util_Exception_Base{      
    
   public function __construct($message = null, $code = 0) {
      $t_message = "Exception raised in Miqo Service Exception ";
      $t_message .= "with message : " . $message;

      parent::__construct($t_message, $code);
   }    
}
