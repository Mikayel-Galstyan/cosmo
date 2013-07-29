<?php

class Dao_UserImage extends Miqo_Dao_Base {
    protected $primaryColumn = 'id';
    protected $columnAliases = array (
            'id' => 'id',
            'user_id' => 'userId',
			'path' => 'path');
    
    protected $entityClass = 'Domain_UserImage';

    public function __construct() {
        $this->dbTable = new Dao_DbTable_UserImage();
    }
	
	public function getByUserId($id) {
        $items = $this->dbTable->fetchAll(
                array('user_id = ?' => $id)
        );
       $items = $this->getEntities($items);
       return $items;
    }
    
    
    public function &getOrderedList(Filter_Object $filter = null) {
    	$select = $this->dbTable->select()->from(array('c' => Dao_DbTable_List::USERIMAGE), array('id AS id', 'name AS name'));
    	if($filter) {
    		$select->order( array($filter->getOrder().' '.$filter->getSort()));
    	} else {
    		$select->order('name ASC');
    	}
    	$result = $this->dbTable->fetchAll($select);
    	$items = &$this->getEntities($result);
    	return $items;
    }
}

?>
