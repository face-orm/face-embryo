<?php
    
class Lemon {
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $tree_id;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $mature;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $Tree;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $Seed;
    
    
        
    use \Face\Traits\EntityFaceTrait;
    
    public static function __getEntityFace() {
    
        return [
            "sqlTable"=>"lemon",
            
            "elements"=>[            

                "id"=>[
                    "identifier"=>true,
                    "sql"=>[
                        "isPrimary" => true,
                    ],
                ],
                

                "tree_id"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "mature"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                
                "Tree"=>[
                    "property"=>"Tree",
                    "class"=>"Tree",
                    "relation"=>"belongsTo",
                    "relatedBy"=>"Lemon",
                    "sql"=>[
                    "join" => ["tree_id"=>"id"]
                    ],
                ],
                
                "Seed"=>[
                    "property"=>"Seed",
                    "class"=>"Seed",
                    "relation"=>"hasMany",
                    "relatedBy"=>"Lemon",
                    "sql"=>[
                    "join" => ["id"=>"lemon_id"]
                    ],
                ],
                
                
                
            ]
        ];
    
    }

}