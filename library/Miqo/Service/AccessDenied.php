<?php
/**
 * @package library_Miqo_service
 */

/**
 * The exception class for access problems.
 *
 * @package library_Miqo_service
 */
class Miqo_Service_AccessDenied extends Miqo_Util_Exception_Base {
    
    /**
     * The class constructor.
     *
     * Specifies error message.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct($message = null, $code = 0) {

      $t_message = "Exception raised in Miqo Service_AccessDenied Exception ";
      $t_message .= "with message : " . $message;

      parent::__construct($t_message, $code);

    }    
}
