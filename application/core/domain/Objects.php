<?php

class Domain_Objects extends Miqo_Domain_AbstractEntity {
    /**
     *
     * @var string
     */
    protected $description = null;
    /**
     *
     * @var string
     */
    protected $path = null;
    /**
     *
     * @var string
     */
    protected $name = null;
    /**
     *
     * @var int
     */
    protected $cost = null;
    /**
     *
     * @var int
     */
    protected $publisherId = null;
    /**
     *
     * @var int
     */
    protected $objectTypeId = null;
    /**
     *
     * @var int
     */
    protected $shopListId = null;
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
    public function getPopulation() {
        return $this->population;
    }
    public function &setPopulation($val) {
        $this->population = $val;
        return $this;
    }
    public function getDescription() {
        return $this->description;
    }
    public function &setDescription($val) {
        $this->description = $val;
        return $this;
    }
    
     public function getCost() {
        return $this->cost;
    }
    public function &setCost($val) {
        $this->cost = $val;
        return $this;
    }
    public function getPath() {
        return $this->path;
    }
    public function &setPath($val) {
        $this->path = $val;
        return $this;
    }
    
     public function getPublisherId() {
        return $this->publisherId;
    }
    public function &setPublisherId($val) {
        $this->publisherId = $val;
        return $this;
    }
    public function getObjectTypeId() {
        return $this->objectTypeId;
    }
    public function &setObjectTypeId($val) {
        $this->objectTypeId = $val;
        return $this;
    }
    
     public function getShopListId() {
        return $this->shopListId;
    }
    public function &setShopListId($val) {
        $this->shopListId = $val;
        return $this;
    }
}
?>