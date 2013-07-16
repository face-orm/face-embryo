<?php

namespace App;

/**
 * Description of DbClass
 *
 * @author soufiane
 */
class DbRelation {
    
    protected $name;
    /**
     *
     * @var DbProperty
     */
    protected $referencingColumn;
    
    /**
     *
     * @var DbProperty
     */
    protected $referencedColumn;
    
    
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getReferencingColumn() {
        return $this->referencingColumn;
    }

    public function setReferencingColumn(DbProperty $referencingColumn) {
        $this->referencingColumn = $referencingColumn;
    }

    public function getReferencedColumn() {
        return $this->referencedColumn;
    }

    public function setReferencedColumn(DbProperty $referencedColumn) {
        $this->referencedColumn = $referencedColumn;
    }


    
}

