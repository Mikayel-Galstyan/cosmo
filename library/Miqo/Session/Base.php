<?php
/**
 * @package library_Miqo_session
 */

/**
 * The base class for session.
 *
 * @package library_Miqo_session
 */
class Miqo_Session_Base {
    
    /**
     * @var Zend_Session_Namespace
     */
    private $session = null;
    
    /**
     * The class constructor.
     * 
     * Initialises the session.
     * @param string $nameSpace
     */
    public function __construct($nameSpace = "default") {
        // set up the session
        if (!$this->session){
            $this->session = new Zend_Session_Namespace($nameSpace);
        }
        $this->session->setExpirationSeconds(Zend_Registry::get('session_timeout'));
        session_write_close();
    }
    
    /**
     * Serializes an object and writes it in the session.
     * 
     * @param string $sessionName
     * @param mixed $object
     * @return void
     */
    public function set($sessionName, $object) {
        session_start();
        $this->session->$sessionName = serialize($object);
        session_write_close();
    }
    
    /**
     * Returns unserialized data from the session.
     * 
     * @param string $sessionName
     * @return mixed
     */
    public function get($sessionName = 'custom') {
        session_start();
        $session = unserialize($this->session->$sessionName);
        session_write_close();
        return $session;
    }
}
?>