<?php

namespace App;

/**
 * Description of DbClass
 *
 * @author soufiane
 */
class DbProperty {
    
    protected $columnName;
    protected $isPrimary;
    
    public function getColumnName() {
        return $this->columnName;
    }

    public function setColumnName($columnName) {
        $this->columnName = $columnName;
    }

   

    public function getIsPrimary() {
        return $this->isPrimary;
    }

    public function setIsPrimary($isPrimary) {
        $this->isPrimary = $isPrimary;
    }


    
}

