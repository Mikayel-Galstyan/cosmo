<?php

class Service_UserImage extends Miqo_Service_Base {
    private $validator = null;
    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_UserImage();
    }
	
	public function getByUserId($id) {
		$item = $this->dao->getByUserId($id);
		return $item;
	}
	
	public function &__t_save(Domain_UserImage $domain) { 	
		$domain = $this->dao->save($domain);
		return $domain;
    }
}
?>