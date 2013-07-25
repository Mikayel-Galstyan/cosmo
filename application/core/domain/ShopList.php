<?php

class Domain_ShopList extends Miqo_Domain_AbstractEntity {
    /**
     *
     * @var string
     */
    protected $address = null;
    /**
     *
     * @var string
     */
    protected $name = null;
    /**
     *
     * @var string
     */
    protected $phone = null;
	 /**
	 *
	 * @var int
	 */
    protected $publisherId = null;
	/**
	 *
	 * @var string
	 */
    protected $description = null;
     /**
     *
     * @var int
     */
    protected $population = null;
    
    
    public function getAddress() {
        return $this->userId;
    }
    public function &setAddress($val) {
        $this->userId = $val;
        return $this;
    }
    
    public function getName() {
        return $this->name;
    }
    public function &setName($val) {
        $this->name = $val;
        return $this;
    }
    
    public function getPopulation() {
        return $this->population;
    }
    public function &setPopulation($val) {
        $this->population = $val;
        return $this;
    }
	
	public function getPhone() {
        return $this->phone;
    }
    public function &setPhone($val) {
        $this->phone = $val;
        return $this;
    }
	
    public function getPublisherId() {
        return $this->publisherId;
    }
    public function &setPublisherId($val) {
        $this->publisherId = $val;
        return $this;
    }
	
	public function getDescription() {
        return $this->description;
    }
    public function &setDescription($val) {
        $this->description = $val;
        return $this;
    }
}
?>