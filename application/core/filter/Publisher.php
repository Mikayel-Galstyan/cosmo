<?php
class Filter_Publisher {
    /**
     *
     * @var int
     */
    protected $userId = null;
    /**
     *
     * @var int
     */
    protected $clicks = null;
    /**
     *
     * @var int
     */
    protected $population = null;

    public function getUserId() {
        return $this->userId;
    }
    public function &setUserId($val) {
        $this->userId = $val;
        return $this;
    }
    
    public function getClicks() {
        return $this->clicks;
    }
    public function &setClicks($val) {
        $this->clicks = $val;
        return $this;
    }
    
    public function getPopulation() {
        return $this->population;
    }
    public function &setPopulation($val) {
        $this->population = $val;
        return $this;
    }
    
}