<?php
class Filter_ShopList {
    /**
     *
     * @var int
     */
    protected $publisherId = null;

    public function getPublisherId() {
        return $this->publisherId;
    }
    public function &setPublisherId($val) {
        $this->publisherId = $val;
        return $this;
    }
  
}