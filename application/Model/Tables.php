<?php

namespace Model;


class Tables{
    
    protected $table_schema;
    protected $table_name;
    
    protected $columns;
    
    
    public function getTable_name() {
        return $this->table_name;
    }

    public function getColumns() {
        return $this->columns;
    }

    public function getPrimaries(){
        $p =[];
        
        foreach ($this->columns as $c){
            
            if($c->isPrimary()){
                $p[] = $c;
            }
            
        }
        return $p;
    }

    public function getForeignKeys(){
        $p =[];
        
        foreach ($this->columns as $c){
            
            if($c->isForeignKey()){
                $p[] = $c->getForeignKey();
            }
            
        }
        return $p;
    }

    
    
    use \Face\Traits\EntityFaceTrait;
    
    public static function __getEntityFace() {
        
        return [
            
            "sqlTable"=>"tables",
            
            "table_schema"=>[
                "identifier"=>true,
                "sql"=>[
                    "isPrimary" => true
                ]
            ],
            
            "elements"=>[
                "table_schema"=>[
                ],
                "table_name"=>[
                    "identifier"=>true,
                    "sql"=>[
                        "isPrimary" => true
                    ]
                ],
                "columns"=>[
                    "class"     => "Model\Columns",
                    "relation"  => "hasMany",
                    "relatedBy" => "table",
                    "sql"   =>[
                        "join"  => [
                            "table_name"   => "table_name",
                            "table_schema" => "table_schema"
                        ]
                    ]
                ],
              
            ]
            
        ];
        
    }
    
}