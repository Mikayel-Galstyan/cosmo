<?php
class Filter_Objects extends Filter_Order {
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

    public function getPublisherId() {
        return $this->publisherId;
    }
    public function &setPublisherId($val) {
        $this->publisherId = $val;
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