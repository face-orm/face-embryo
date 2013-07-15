<?php

namespace Model;


class Columns{
    
    protected $column_name;
    
    protected $table_name;
    
    protected $table_schema;


    protected $keyColumnUsages;
    
    protected $keyColumnUsagesReferencing;


    protected $table;
    
    
    public function getKeyColumnUsages() {
        return $this->keyColumnUsages;
    }

        
    
    public function getTable_name() {
        return $this->table_name;
    }

    public function getColumn_name() {
        return $this->column_name;
    }



    
    
    use \Face\Traits\EntityFaceTrait;
    
    public static function __getEntityFace() {
        
        return [
            
            "sqlTable"=>"columns",
            
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
                
                "keyColumnUsages"=>[
                    "class"=>"Model\KeyColumnUsage",
                    "relation"=>"hasMany",
                    "relatedBy"=>"column",
                    "sql"   =>[
                        "join"  => [
                            "column_name"   => "column_name",
                            "table_name"   => "table_name",
                            "table_schema" => "table_schema"
                        ]
                    ]
                ],
                
                "keyColumnUsagesReferencing"=>[
                    "class"=>"Model\KeyColumnUsage",
                    "relation"=>"hasMany",
                    "relatedBy"=>"referencedColumn",
                    "sql"   =>[
                        "join" => [
                            "table_name"   => "referenced_table_name",
                            "table_schema" => "referenced_table_name",
                            "column_name"  => "referenced_table_name"
                        ]
                    ]
                ],
                
                "table"=>[
                    "class"=>"Model\Tables",
                    "relatedBy"=>"columns",
                    "sql"   =>[
                        "join"  => [
                            "table_name"   => "table_name",
                            "table_schema" => "table_schema"
                        ]
                    ]
                ]
               
              
            ]
            
        ];
        
    }
    
}