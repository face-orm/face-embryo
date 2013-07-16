<?php

namespace App;

/**
 * Description of DbClass
 *
 * @author soufiane
 */
class DbClass {
    
    private static $camelFilter;
    
    protected $tableName;
    protected $namespace;
    
    protected $properties=array();
    protected $entities=array();
    
    
    private static function getCamelFilter(){
        if(!self::$camelFilter){
            $filterChain = new \Zend\Filter\FilterChain();
            $filterChain->attach(new \Zend\Filter\Word\UnderscoreToCamelCase());
            $filterChain->attach(new \Zend\Filter\Word\DashToCamelCase());
            self::$camelFilter=$filterChain;
        }
        
        return self::$camelFilter;
    }
    
    public function getProperties() {
        return $this->properties;
    }

    public function addProperty($properties) {
        $this->properties[] = $properties;
    }

    public function getEntities() {
        return $this->entities;
    }

    public function addEntity($entities) {
        $this->entities[] = $entities;
    }

    public function getCamelClassName(){
        return ucfirst(self::getCamelFilter()->filter($this->getTableName()));
    }

    public function getTableName() {
        return $this->tableName;
    }

    public function setTableName($tableName) {
        $this->tableName = $tableName;
    }

    public function getNamespace() {
        return $this->namespace;
    }

    public function setNamespace($namespace) {
        $this->namespace = $namespace;
    }


    
}

