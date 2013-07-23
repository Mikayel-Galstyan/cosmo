<?php
/**
 * @package library_tf_domain
 */

/**
 * The base class for traceable domain classes.
 *
 * @package library_tf_domain
 */
class Miqo_Domain_AbstractTraceableEntity extends Miqo_Domain_AbstractEntity {    
    /**
     * @var array
     */
    private static $traceableDateColumns = array('created_at', 'changed_at' );
    /**
     * @var array
     */
    private static $traceableColumnAliases = array (
            'created_at' => 'createdAt',
            'created_by' => 'createdBy',
            'changed_at' => 'changedAt',
            );
   /**
    * An id of the creator object for tracing.
    * 
    * @var int
    */
   protected $createdBy = null;
   /**
    * @var Miqo_Util_Date
    */
   protected $createdAt = null;
   /**
    * @var Miqo_Util_Date
    */
   protected $changedAt = null;
   
   /**
    * Returns an id of the object�s creator.
    * 
    * @return int
    */
   public function getCreatedBy() {
      return $this->createdBy;
   }

   /**
    * Sets an id of the object�s creator.
    * 
    * @param createdBy
    */
   public function &setCreatedBy($createdBy) {
      $this->createdBy = $createdBy;
      return $this;
   }

   /**
    * Gets the time stamp of creation.
    * 
    * @return Miqo_Util_Date
    */
   public function getCreatedAt() {
      return $this->createdAt;
   }

   /**
    * Sets the timestamp of creation.
    * 
    * @param Miqo_Util_Date $createdAt
    * @return TF_Domain_AbstractTraceableEntity
    */
   public function &setCreatedAt(Miqo_Util_Date &$createdAt) {
      $this->createdAt = $createdAt;
      return $this;
   }

    /**
    * Returns the timestamp of management activity.
    * 
    * @return Miqo_Util_Date
    */
   public function getChangedAt() {
      return $this->changedAt;
   }

   /**
    * Sets the timestamp of management activity.
    * 
    * @param Miqo_Util_Date $changedAt
    * @return TF_Domain_AbstractTraceableEntity
    */
   public function &setChangedAt(Miqo_Util_Date &$changedAt) {
      $this->changedAt = $changedAt;
      return $this;
   }
   
   /**
    * Returns traceable date columns.
    * 
    * @return array
    */
   public static function getTraceableDateColumns() {
      return self::$traceableDateColumns;
   }
   
   /**
    * Returns traceable columns aliases.
    * 
    * @return array
    */
   public static function getTraceableColumnAliases() {
      return self::$traceableColumnAliases;
   }
}
?>