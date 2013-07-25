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
            'shopList_id' => 'shopListId',
            'population' => 'population');
    
    protected $entityClass = 'Domain_Objects';

    public function __construct() {
        $this->dbTable = new Dao_DbTable_Objects();
    }
	
    
    public function &getByParams(Filter_Objects $filter){
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
        if($filter->getShopListId()){
            $select->where('shopList_id = ?', $filter->getShopListId());
        }
        if($filter->getPublisherId()){
            $select->where('publisher_id = ?', $filter->getPublisherId());
        }
        if($filter->getObjectTypeId()){
            $select->where('objectType_id = ?', $filter->getObjectTypeId());
        }
        if($filter->getCostMin()){
            $select->where('cost >=', $filter->getCostMin());
        }
        if($filter->getCostMax()){
            $select->where('cost <=', $filter->getCostMax());
        }
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
