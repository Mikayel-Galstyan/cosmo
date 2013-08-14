<?php

class Dao_Publisher extends Miqo_Dao_Base {
    protected $primaryColumn = 'id';
    protected $columnAliases = array (
            'id' => 'id',
            'name' => 'name',
			'status' => 'status',
    		'order' => 'order',
            'address' => 'address',
            'phone' => 'phone',
            'site' => 'site',
            'clicks' => 'clicks',
            'user_id' => 'userId',
            'start_order_date' => 'startOrderDate',
            'population' => 'population');
    
    protected $entityClass = 'Domain_Publisher';

    public function __construct() {
        $this->dbTable = new Dao_DbTable_Publisher();
    }
    
    
    public function &getByParams(Filter_Publisher $filter) {
    	$select = $this->dbTable->select()->from(array('c' => Dao_DbTable_List::PUBLISHER));
    	if($filter->getUserId()){
            $select->where('user_id = ?', $filter->getUserId());
        }
    	$result = $this->dbTable->fetchAll($select);
    	$items = &$this->getEntities($result);
    	return $items;
    }
}

?>
