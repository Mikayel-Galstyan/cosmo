<?php

/**
 * @package library_Miqo_service
 */

/**
 * The abstract base class for service classes
 *
 * @package library_Miqo_service
 */
abstract class Miqo_Service_Base {
    /**
     * @var Miqo_Dao_Base
     */
    protected $dao = null;
    /**
     * @var Zend_Log
     */
    protected $LOG = null;
    /**
     * @var Zend_Db_Adapter_Abstract
     */
    protected $dbAdapter = null;
    /**
     * @var Miqo_Cache_Core
     */
    protected $cache = null;
    /**
     * @var boolean
     */
    protected static $transactionOpen = false;

    /**
     * The class constructor.
     * 
     * Initialises properties.
     */
    public function __construct() {
        $this->dbAdapter = Zend_Db_Table_Abstract::getDefaultAdapter();
        $this->LOG = Zend_Registry::get('log');
    }

    /**
     * Starts the transaction.
     * 
     * @return void
     */
    protected function startTransaction() {
        $this->dbAdapter->beginTransaction();
        self::$transactionOpen = true;

        $this->LOG->debug("Transaction started.");
    }

    /**
     * Closes transaction.
     * 
     * @return void
     */
    protected function endTransaction() {
        $this->dbAdapter->rollBack();
        self::$transactionOpen = false;
        $this->LOG->debug("Transaction closed.");
    }

    /**
     * Commits transaction.
     * 
     * @return void
     */
    protected function commitTransaction() {
        $this->dbAdapter->commit();

        $this->LOG->debug("Transaction committed.");
    }

    /**
     * Rollbacks transaction.
     * 
     * @param Zend_Exception $ex
     */
    protected function rollbackTransaction($ex = null) {
        $this->dbAdapter->rollBack();
        $message = is_null($ex) ? "Transaction rollbacked" : "Transaction rollbacked with the following message: $ex";

        $this->LOG->err($message);
    }

    /**
     * Provides supporting transactions and memory caching.
     * 
     * @param string $name
     * @param array $args
     * @throws Miqo_Util_Exception_Validation
     * @throws Miqo_Util_Exception_AdServer
     * @throws Miqo_Util_Exception_Service
     * @throws Miqo_Util_Exception_NoSuchMethod
     * @return mixed
     */
    public function __call($name, $args) {
        // check for transaction method call
        $transactionalName = "__t_$name";
        if (method_exists($this, $transactionalName)) {
            $result = null;

            // check if transaction is already opened
            if (self::$transactionOpen) {
                $this->LOG->debug("Transaction is already started.");
                $result = call_user_func_array(array ($this, $transactionalName ), $args);
            } else {
                try {
                    $this->startTransaction();
                    // call the helper method
                    $result = call_user_func_array(array ($this, $transactionalName ), $args);
                    
                    //Change version for entities
                    $versionFunctions = $this->getVersionFunctions();
                    if (isset($versionFunctions[$name])) {
                        $cache = &$this->cache;
                        foreach ($versionFunctions[$name] as $value) {
                           $cache->increment($value);
                        }
                    }
                    // commit transaction
                    $this->commitTransaction();
                    // end transaction
                    $this->endTransaction();
                } catch ( Miqo_Util_Exception_Validation $vex ) {
                    $this->rollbackTransaction($vex);
                    $this->endTransaction();
                    throw $vex;
                }  catch ( Zend_Exception $ex ) {
                    $this->rollbackTransaction($ex);
                    $this->endTransaction();
                    throw new Miqo_Util_Exception_Service($ex);
                }
            }
            
        } else {
            $cacheName = "__c_$name";
            if (method_exists($this, $cacheName)) {
                try {
                    $cache = &$this->cache;

                    $className = get_class($this);
                    $methodName = $name;
                    $versionKeys = $this->getVersionKeys();
                    $versionKeys = $versionKeys[$name];
                    $cacheKey = $cache->generateCacheKey($className, $methodName, $args, $versionKeys);

                    if (($result = $cache->getCached($cacheKey)) === null) {
                        $result = call_user_func_array(array($this, $cacheName), $args);
                        $cache->cache($cacheKey, $result);
                    } else {
                        // cache hit! shout so that we know
                    }
                } catch (Zend_Exception $ex) {
                    throw new Miqo_Util_Exception_Service($ex);
                }
            } else {
                throw new Miqo_Util_Exception_NoSuchMethod($name);
            }
        }
        
        return $result;
    }

    /**
     * Returns functions and array of fields which can be changed by them.
     * 
     * @return array
     */
    protected function getVersionFunctions() {
        return array();
    }

    /**
     * Returns functions and array of fields which are used by them.
     * 
     * @return array
     */
    protected function getVersionKeys() {
        return array();
    }

    /**
     * Selects by id.
     * 
     * Selects the row by id from the defined database table and returns valid domain object.
     * 
     * @param int $id
     * @return Miqo_Domain_AbstractEntity|void
     */
    public function getById($id) {
        $domain = $this->dao->getById($id);
        //checking of domain correctness
        if ($this->isValid($domain)){
            return $domain;
        }
    }

    /**
     * Selects all.
     * 
     * Selects all data from the defined database table and sets to the specified domain objects.
     * 
     * @return array
     */
    public function getAll() {
        $domains = $this->dao->getAll();
        return $domains;
    }

    /**
     * Deletes an item from specified database table by id (supports transactions).
     * 
     * @param int $id
     * @throws Miqo_Util_Exception_Service
     * @return Miqo_Domain_AbstractEntity
     */
    public function __t_delete($id) {
        $domain = $this->dao->getById($id);
        if($this->isValid($domain)){
            try {
                $domain = $this->dao->delete($id);
            } catch ( Zend_Exception $ex ) {
                $this->rollbackTransaction();
                $this->endTransaction();
                throw new Miqo_Util_Exception_Service($ex);
            }
            return $domain;
        }
    }
    
    /**
     * Deletes an items from specified database table by id (supports transactions).
     * 
     * @param int $id
     * @throws Miqo_Util_Exception_Service
     * @return Miqo_Domain_AbstractEntity
     */
    public function __t_deleteList($idList){
        try {
            foreach($idList as $id){
                $domain = $this->dao->delete($id);
            }
        } catch ( Zend_Exception $ex ) {echo $ex->getMessage();
            $this->rollbackTransaction();
            $this->endTransaction();
            throw new Miqo_Util_Exception_Service($ex);
        }
    }
    
    
    /**
     * Provides validation by current user�s country id.
     * 
     * @param Miqo_Domain_AbstractEntity $domain
     * @throws Miqo_Service_AccessDenied
     * @throws Miqo_Service_ItemNotExists
     */
    public function validateEntity($domain) {
        if ($domain){
            $userSession = new Miqo_Session_Base();
            $className = get_class($domain);
        } else {
            $userSession = new Miqo_Session_Base();
            $message = 'User with id='.$userSession->get('authUser')->getId().' tries to get an item that does not exist in the database';
            throw new Miqo_Service_ItemNotExists($message);
        }
    }
    
    /**
     * Provides validation.
     * 
     * @param arary $domains
     * @return boolean
     */
    public function isValid($domains) {
        if(is_array($domains)){
            foreach ($domains as $domain){
                $this->validateEntity($domain);
            }
        } else {
            $this->validateEntity($domains);
        }
        return true;
    }

} // END class
?>