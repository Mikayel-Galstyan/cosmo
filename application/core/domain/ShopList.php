<?php

class Domain_ShopList extends Miqo_Domain_AbstractEntity {
    /**
     *
     * @var int
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
    protected $publisherId = null;
	/**
	 *
	 * @var int
	 */
    protected $description = null;
    
    
    
    public function getAddress() {
        return $this->userId;
    }
    public function &setAddress($val) {
        $this->userId = $val;
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