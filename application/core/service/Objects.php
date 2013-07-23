<?php

class Service_Objects extends Miqo_Service_Base {
    private $validator = null;
    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Objets();
    }
    
    public function getByTypeId($id){
        $this->dao->getByTypeId($id);
    }
    

}
?>