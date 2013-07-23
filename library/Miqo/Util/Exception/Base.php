<?php

class Miqo_Util_Exception_Base extends Zend_Exception {
   public function __construct($message = null, $code = 0) {
      $t_message = "Exception raised in Miqo Base Exception ";
      $t_message .= "with message : " . $message;

      parent::__construct($t_message, $code);
   }    
}
