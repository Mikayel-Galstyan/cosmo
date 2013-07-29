<?php

class Service_LoveList extends Miqo_Service_Base {
    private $validator = null;
    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_LoveList();
    }
	
	public function &__t_save(Domain_LoveList $domain) { 	
		$domain = $this->dao->save($domain);
		return $domain;
    }
	
	public function getByUserId($id){
		$domain = $this->dao->getByUserId($id);
		return $domain;
	}

}
?>