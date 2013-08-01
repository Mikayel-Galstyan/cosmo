<?php

class Domain_Publisher extends Miqo_Domain_AbstractEntity {
    /**
     *
     * @var string
     */
    protected $name = null;
	/**
     *
     * @var string
     */
    protected $status = null;
    /**
     *
     * @var string
     */
    protected $order = null;
    /**
     *
     * @var string
     */
    protected $address = null;
    /**
     *
     * @var int
     */
    protected $phone = null;
    /**
     *
     * @var int
     */
    protected $site = null;
    /**
     *
     * @var int
     */
    protected $clicks = null;
    /**
     *
     * @var int
     */
    protected $userId = null;
    /**
     *
     * @var int
     */
    protected $startOrderDate = null;
     /**
     *
     * @var int
     */
    protected $population = null;
    
    
    public function getName() {
        return $this->name;
    }
    public function &setName($val) {
        $this->name = $val;
        return $this;
    }
	
	public function getStatus() {
        return $this->status;
    }
    public function &setStatus($val) {
        $this->status = $val;
        return $this;
    }
    
    public function getPopulation() {
        return $this->population;
    }
    public function &setPopulation($val) {
        $this->population = $val;
        return $this;
    }
    
    public function getOrder() {
        return $this->order;
    }
    public function &setOrder($val) {
        $this->order = $val;
        return $this;
    }
    
    public function getAddress() {
        return $this->address;
    }
    public function &setAddress($val) {
        $this->address = $val;
        return $this;
    }
    public function getPhone() {
        return $this->phone;
    }
    public function &setPhone($val) {
        $this->phone = $val;
        return $this;
    }
    
    public function getSite() {
        return $this->site;
    }
    public function &setSite($val) {
        $this->site = $val;
        return $this;
    }
    public function getClicks() {
        return $this->clicks;
    }
    public function &setClicks($val) {
        $this->clicks = $val;
        return $this;
    }
    
    public function getUserId() {
        return $this->userId;
    }
    public function &setUserId($val) {
        $this->userId = $val;
        return $this;
    }
    
    public function getStartOrderDate() {
        return $this->startOrderDate;
    }
    public function &setStartOrderDate($val) {
        $this->startOrderDate = $val;
        return $this;
    }
}
?>