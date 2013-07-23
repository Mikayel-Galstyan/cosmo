<?php

class Dao_Publisher extends Miqo_Dao_Base {
    protected $primaryColumn = 'id';
    protected $columnAliases = array (
            'id' => 'id',
            'name' => 'name',
    		'order' => 'order',
            'address' => 'address',
            'phone' => 'phone',
            'site' => 'site',
            'clicks' => 'clicks',
            'user_id' => 'userId',
            'start_order_date' => 'startOrderDate');
    
    protected $entityClass = 'Domain_Publisher';

    public function __construct() {
        $this->dbTable = new Dao_DbTable_Publisher();
    }
	
    
    
    public function &getOrderedList(Filter_Object $filter = null) {
    	$select = $this->dbTable->select()->from(array('c' => Dao_DbTable_List::PUBLISHER), array('id AS id', 'name AS name'));
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
