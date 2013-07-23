<?php
/**
 * @package library_tf_dao
 */

/**
 * The base class for data access level classes.
 *
 * @package library_tf_dao
 */
class Miqo_Dao_Base {
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $dbTable = null;
    /**
     * @var array
     */
    protected $primaryColumn = null;
    /**
     * @var array
     */
    protected $columnAliases = array ();
    /**
     * @var array
     */
    protected $customAliases = array ();
    /**
     * @var array
     */ 
    protected $dateColumns = array ();
    /**
     * @var string
     */
    protected $entityClass = null;

    /**
     * The class constructor.
     * 
     * Merges defined data columns and column aliases with the traceables.
     */
    public function __construct() {
        if (get_parent_class($this->entityClass) == 'Miqo_Domain_AbstractTraceableEntity') {
            $this->dateColumns = array_merge($this->dateColumns, Miqo_Domain_AbstractTraceableEntity::getTraceableDateColumns());
            $this->columnAliases = array_merge($this->columnAliases, Miqo_Domain_AbstractTraceableEntity::getTraceableColumnAliases());        
        }
    }

    /**
     * Selects by id.
     * 
     * Selects the row by id from the defined database table and sets all data to the specified domain object.
     * 
     * @param int $id
     * @return TF_Domain_AbstractEntity|null
     */
    public function &getById($id) {
        $entity = null;

        $entityRowset = $this->dbTable->find($id);
        if (sizeof($entityRowset) == 1) {
            $entity = &$this->getEntity($entityRowset [0]);
        }
        return $entity;
    }

    /**
     * Selects all.
     * 
     * Selects all data from the defined database table and sets to the specified domain objects.
     * 
     * @return array
     */
    public function &getAll() {
        $entityRowset = $this->dbTable->fetchAll();
        $entities = &$this->getEntities($entityRowset);
        return $entities;
    }
    
    /**
     * Selects by country id.
     * 
     * Selects all data from the defined database table by country id and sets to the specified domain objects.
     * 
     * @param int $countryId
     * @return array
     */
    public function getAllByCountryId($countryId) {
        $entityRowset = $this->dbTable->fetchAll(array('country_id = ?' => $countryId));
        $entities = &$this->getEntities($entityRowset);
        return $entities;
    }

    /**
     * Saves data.
     * 
     * Saves data to the defined database table using the data from the entity object. 
     * If aliases are set, only the value of specified fields are used.
     * 
     * @param TF_Domain_AbstractEntity $entity
     * @param array $aliases
     * @return TF_Domain_AbstractEntity|TF_Domain_AbstractTraceableEntity
     */
    public function &save(Miqo_Domain_AbstractEntity &$entity, &$aliases=null) {
        
        $id = $entity->getId();

        $newEntity = ($id === null);

        if ($entity instanceof Miqo_Domain_AbstractTraceableEntity) {
            $user_id = 0;
            
            //Get Logged user id
            $userSession = new Miqo_Session_Base();
            $user = $userSession->get('authUser');
            if ($user) {
                $user_id = $user->getId();
            }

            $updateTime = new Miqo_Util_Date();
            if ($newEntity) {
                $createdBy = $entity->getCreatedBy();
                if ($createdBy === null) {
                    $entity->setCreatedBy($user_id);
                }
                $createdAt = $entity->getCreatedAt();
                if ($createdAt === null) {
                    $entity->setCreatedAt($updateTime);
                }
            }
            $entity->setChangedAt($updateTime);
        }
        
        $data = &$this->getEntityValues($entity, $aliases);
        
        if ($newEntity) {
            $id = $this->dbTable->insert($data);
            $entity->setId($id);
        } else {
            $this->dbTable->update($data, array ($this->primaryColumn . ' = ?' => $id ));
        }

        // do we really need this?
        return $entity;
    }

    /**
     * Deletes an item from specified database table by id.
     * 
     * @param int $id
     * @return boolean
     */
    public function delete($id) {
        return $this->dbTable->delete(array ($this->primaryColumn . ' = ?' => $id ));
    }

    /**
     * Converts the row to the specified domain class.
     * 
     * If aliases are set, only the value of specified fields are used.
     * 
     * @param Zend_Db_Table_Row $row
     * @param array $aliases
     * @return TF_Domain_AbstractEntity
     */
    protected function &getEntity($row, $aliases=null) {
        if (!$aliases){
            $aliases = $this->columnAliases;
        }
        $dateColumns = &$this->dateColumns;
        $result = new $this->entityClass();

            foreach ( $aliases as $column => $property ) {
                if(isset($row->{$column})){
                    $setPropertyMethod = 'set' . ucfirst($property);
                    $propertyValue = $row->{$column};
                    if (in_array($column, $dateColumns)) {
                        $propertyValue = ($propertyValue != '0000-00-00 00:00:00' &&  $propertyValue != '0000-00-00') ? new Miqo_Util_Date($propertyValue) : '';
                    }
                    $result->$setPropertyMethod($propertyValue);
                }
            }

        return $result;
    }

    /**
     * Converts the rowset to the array of specified domain classes. 
     * 
     * If aliases are set, only the value of specified fields are used.
     * 
     * @param Zend_Db_Table_Rowset $rowset
     * @param array $aliases
     * @return array 
     */
    protected function &getEntities(&$rowset, &$aliases=null) {
        if (!$aliases){
            $aliases = $this->columnAliases;
        }
        $result = array ();
        foreach ( $rowset as $row ) {
            $result [] = &$this->getEntity($row, $aliases);
        }
        return $result;
    }

    protected function &getEntities_new(&$rowset, &$aliases=null) {
        if (!$aliases){
            $aliases = $this->columnAliases;
        }
        $result = array ();
        $dateColumns = &$this->dateColumns;
        $propertyMethods = array();
        $columnsDate = array();
        foreach ( $aliases as $column => $property ) {
            $propertyMethods[$column] = 'set' . ucfirst($property);
            $columnsDate[$column] = in_array($column, $dateColumns);
        }

        foreach ( $rowset as $row ) {
            $entity = new $this->entityClass();

            foreach ( $aliases as $column => $property ) {
                if(isset($row->{$column})){
                    $propertyValue = $row->{$column};
                    if ($columnsDate[$column]) {
                        $propertyValue = ($propertyValue != '0000-00-00 00:00:00' &&  $propertyValue != '0000-00-00') ? new Miqo_Util_Date($propertyValue) : '';
                    }
                    $entity->$propertyMethods[$column]($propertyValue);
                }
            }

            $result [] = $entity;
        }
        return $result;
    }

    protected function &getEntityValues(Miqo_Domain_AbstractEntity &$entity, &$aliases=null) {
        $result = array ();
        $this->populateEntityValues($entity, $result, $aliases);
        return $result;
    }

    /**
     * Converts TF_Domain_AbstractEntity to array.
     * 
     * Converts TF_Domain_AbstractEntity to array and sets in Zend_Db_Table_Row. 
     * If $aliases is set, only the value of specified fields are used.
     * 
     * @param TF_Domain_AbstractEntity $entity
     * @param array $row
     * @param array $aliases
     */
    protected function populateEntityValues(Miqo_Domain_AbstractEntity &$entity, &$row, &$aliases=null) {
        $dateColumns = &$this->dateColumns;
        if (!$aliases){
            $aliases = $this->columnAliases;
        }
        foreach ( $aliases as $column => $property ) {
            $getPropertyMethod = 'get' . ucfirst($property);
            $propertyValue = $entity->$getPropertyMethod();
            if ($propertyValue !== null) {
                if (in_array($column, $dateColumns)) {
                    $row [$column] = ($propertyValue instanceof Miqo_Util_Date) ? $propertyValue->getByIsoFormat(false) : $propertyValue;
                } else {
                    $row [$column] = $propertyValue;
                }
            }
        }
    }
} // END class 

?>
