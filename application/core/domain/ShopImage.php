<?php

class Domain_ShopImage extends Miqo_Domain_AbstractEntity {
    /**
     *
     * @var int
     */
    protected $shopListId = null;
    /**
     *
     * @var int
     */
    protected $path = null;
    
    
	
    public function getShopListId() {
        return $this->shopListId;
    }
    public function &setShopListId($val) {
        $this->shopListId = $val;
        return $this;
    }
	
	public function getPath() {
        return $this->path;
    }
    public function &setPath($val) {
        $this->path = $val;
        return $this;
    }
}
?>