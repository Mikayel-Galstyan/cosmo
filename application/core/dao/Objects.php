<?php

class Dao_Objects extends Miqo_Dao_Base {
    protected $primaryColumn = 'id';
    protected $columnAliases = array (
            'id' => 'id',
            'description' => 'description',
    		'path' => 'path',
            'name' => 'name',
            'cost' => 'cost',
            'publisher_id' => 'publisherId',
            'objectType_id' => 'objectTypeId',
            'shopList_id' => 'shopListId');
    
    protected $entityClass = 'Domain_Objects';

    public function __construct() {
        $this->dbTable = new Dao_DbTable_Objects();
    }
	
    
    public function &getByTypeId($id){
        $select = $this->dbTable->select()->from(array('c' => Dao_DbTable_List::OBJECTS),array(
        'id AS id', 
        'name AS name',
        'path AS path',
        'description AS description',
        'cost AS cost',
        'publisher_id AS publisherId',
        'objectType_id AS objectTypeId',
        'shopList_id AS shopListId'
        ));
        $select->where('publisher_id = ?', $id);
        $result = $this->dbTable->fetchAll($select);
    	$items = &$this->getEntities($result);
    	return $items;
    }
    
    public function &getOrderedList(Filter_Object $filter = null) {
    	$select = $this->dbTable->select()->from(array('c' => Dao_DbTable_List::OBJECTS), array('id AS id', 'name AS name'));
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
