<?php

class Service_ShopList extends Miqo_Service_Base {
    private $validator = null;
	
    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_ShopList();
    }
	
	public function &__t_save(Domain_ShopList $domain) { 	
            $domain = $this->dao->save($domain);
            return $domain;
    }
	
    public function getByParams(Filter_ShopList $filter){
        $items = $this->dao->getByParams($filter);
        return $items;
    }

}
?>