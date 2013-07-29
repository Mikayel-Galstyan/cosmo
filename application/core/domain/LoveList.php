<?php

class Domain_LoveList extends Miqo_Domain_AbstractEntity {
    /**
     *
     * @var int
     */
    protected $userId = null;
    /**
     *
     * @var int
     */
    protected $objectId = null;
	 /**
	 *
	 * @var int
	 */
    protected $publisherId = null;
	/**
	 *
	 * @var string
	 */
    protected $path = null;
    
    
    
    public function getUserId() {
        return $this->userId;
    }
    public function &setUserId($val) {
        $this->userId = $val;
        return $this;
    }
	
	public function getPath() {
        return $this->path;
    }
    public function &setPath($val) {
        $this->path = $val;
        return $this;
    }
	
	public function getObjectId() {
        return $this->objectId;
    }
    public function &setObjectId($val) {
        $this->objectId = $val;
        return $this;
    }
	
    public function getPublisherId() {
        return $this->publisherId;
    }
    public function &setPublisherId($val) {
        $this->publisherId = $val;
        return $this;
    }
}
?>