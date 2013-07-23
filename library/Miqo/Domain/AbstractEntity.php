<?php
/**
 * @package library_tf_domain
 */

/**
 * The base class for domain classes.
 *
 * @package library_tf_domain
 */
class Miqo_Domain_AbstractEntity {
    /**
    * @var int
    */
    protected $id = null;

    /**
    * Returns an internal identifier.
    * 
    * @return int
    */
    public function getId() {
        return $this->id;
    }

    /**
    * Sets the given internal identifier.
    * 
    * @param int id
    * @return TF_Domain_AbstractEntity
    */
    public function &setId($id) {
        $this->id = (int)$id;
        return $this;
    }
   
    /**
    * Returns the list of class properties.
    *
    * @return array
    */
    public function getProperties() {
        return get_object_vars($this);
    }
}
