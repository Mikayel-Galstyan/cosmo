<?php
/**
 * @package library_Miqo_service
 */

/**
 * The exception class for nonexistent items.
 *
 * @package library_tf_service
 */
class Miqo_Service_ItemNotExists extends Miqo_Util_Exception_Base {
    
    /**
     * The class constructor.
     *
     * Specifies error message.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct($message = null, $code = 0) {

      $t_message = 'Exception raised in Miqo Service_ItemNotExists Exception ';
      $t_message .= 'with message : ' . $message;

      parent::__construct($t_message, $code);

    }    
}
