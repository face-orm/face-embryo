<?php

namespace Model;


class KeyColumnUsage{
    
    
    protected $column_name;
    
    protected $table_name;
    
    protected $table_schema;

    protected $constraint_name;

    protected $referenced_table_schema;
    
    protected $referenced_table_name;
    
    protected $referenced_column_name;

    
    
    protected $column;
    
    protected $referencedColumn;

    protected $table;
    
    public function getConstraint_name() {
        return $this->constraint_name;
    }

    public function setConstraint_name($constraint_name) {
        $this->constraint_name = $constraint_name;
    }

    
    /**
     * 
     * @return \Model\Columns
     */
    public function getReferencedColumn() {
        return $this->referencedColumn;
    }

        
    public function getTable_name() {
        return $this->table_name;
    }

    public function getColumn_name() {
        return $this->column_name;
    }

    
    public function isPrimary(){
        return strtolower($this->getConstraint_name()) === "primary";
    }


    public function getColumn(){
        return $this->column;
    }
    
    
    use \Face\Traits\EntityFaceTrait;
    
    public static function __getEntityFace() {
        
        return [
            
            "sqlTable"=>"key_column_usage",
            
            "elements"=>[
                
                
                "column_name"=>[
                    "identifier"=>true,
                    "sql"=>[
                        "isPrimary" => true
                    ]
                ],
                
                "table_name"=>[
                    "identifier"=>true,
                    "sql"=>[
                        "isPrimary" => true
                    ]
                ],
                
                "table_schema"=>[
                    "identifier"=>true,
                    "sql"=>[
                        "isPrimary" => true
                    ]
                ],
                
                "constraint_name"=>[
                    "identifier"=>true,
                    "sql"=>[
                        "isPrimary" => true
                    ]
                ],
                
                "referenced_table_schema"=>[],
                "referenced_table_name"=>[],
                "referenced_column_name"=>[],
                
                
                "column"=>[
                    "class"=>"Model\Columns",
                    "relatedBy"=>"keyColumnUsages",
                    "relation"=>"hasOne",
                    "sql"  => [
                        "join" => [
                            "table_name"   => "table_name",
                            "table_schema" => "table_schema",
                            "column_name"  => "column_name"
                        ]
                    ]
                ],
                
                "referencedColumn"=>[
                    "class"=>"Model\Columns",
                    "relatedBy"=>"keyColumnUsagesReferencing",
                    "relation"=>"hasOne",
                    "sql"  => [
                        "join" => [
                            "referenced_table_name"   => "table_name",
                            "referenced_table_schema" => "table_schema",
                            "referenced_column_name"  => "column_name"
                        ]
                    ]
                ],
                
        
               
              
            ]
            
        ];
        
    }
    
}