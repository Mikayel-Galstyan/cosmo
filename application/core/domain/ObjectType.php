<?php

class Domain_ObjectType extends Miqo_Domain_AbstractEntity {
    /**
     *
     * @var string
     */
    protected $name = null;
   
     public function getName() {
        return $this->name;
    }
    public function &setName($val) {
        $this->name = $val;
        return $this;
    }
}
?>