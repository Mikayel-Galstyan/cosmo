<?php

class Domain_UserImage extends Miqo_Domain_AbstractEntity {
    /**
     *
     * @var int
     */
    protected $userId = null;
    /**
     *
     * @var string
     */
    protected $path = null;
    
    
    
    public function getPath() {
        return $this->path;
    }
    public function &setPath($val) {
        $this->path = $val;
        return $this;
    }
	
    public function getUserId() {
        return $this->userId;
    }
    public function &setUserId($val) {
        $this->userId = $val;
        return $this;
    }
}
?>