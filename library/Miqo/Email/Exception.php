<?php
/**
 * @package library_TF_email
 */

/**
 * The exception class to provide exceptions for emails.
 *
 * @package library_TF_email
 */
class Miqo_Email_Exception extends Miqo_Util_Exception_Base {
    
    /**
     * The class constructor.
     * 
     * Specifies error message.
     * 
     * @param string $message
     * @param int $code
     */
    public function __construct($message = null, $code = 0) {
        $t_message = "Exception raised in Miqo Email Exception ";
        $t_message .= "with message : " . $message;
        
        parent::__construct($t_message, $code);
    }
}
