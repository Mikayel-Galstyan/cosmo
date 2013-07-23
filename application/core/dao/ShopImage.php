<?php

class Dao_ShopImage extends Miqo_Dao_Base {
    protected $primaryColumn = 'id';
    protected $columnAliases = array (
            'id' => 'id',
            'path' => 'path',
			'shopList_id' => 'shopListId'
			);
    
    protected $entityClass = 'Domain_ShopImage';

    public function __construct() {
        $this->dbTable = new Dao_DbTable_Objects();
    }
	
    
    
    public function &getOrderedList(Filter_Object $filter = null) {
    	$select = $this->dbTable->select()->from(array('c' => Dao_DbTable_List::ShopImage), array('id AS id', 'name AS name'));
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
