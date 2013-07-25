<?php
class Filter_Objects {
    /**
     *
     * @var int
     */
    protected $publisherId = null;
    /**
     *
     * @var int
     */
    protected $shopListId = null;
    /**
     *
     * @var int
     */
    protected $objectTypeId = null;
    /**
     *
     * @var int
     */
    protected $costMin = null;
    /**
     *
     * @var int
     */
    protected $costMax = null;
    /**
     *
     * @var int
     */
    protected $population = null;
    
    
    public function getPopulation() {
        return $this->population;
    }
    public function &setPopulation($val) {
        $this->population = $val;
        return $this;
    }
    
    public function getPublisherId() {
        return $this->publisherId;
    }
    public function &setPublisherId($val) {
        $this->publisherId = $val;
        return $this;
    }
    
    public function getCostMin() {
        return $this->costMin;
    }
    public function &setCostMin($val) {
        $this->costMin = $val;
        return $this;
    }
    
    public function getCostMax() {
        return $this->costMax;
    }
    public function &setCostMax ($val) {
        $this->costMax = $val;
        return $this;
    }
    
    public function getShopListId() {
        return $this->shopListId;
    }
    public function &setShopListId($val) {
        $this->shopListId = $val;
        return $this;
    }
    
    public function getObjectTypeId() {
        return $this->objectTypeId;
    }
    public function &setObjectTypeId($val) {
        $this->objectTypeId = $val;
        return $this;
    }
    
}