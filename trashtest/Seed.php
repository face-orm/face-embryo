<?php
    
class Seed {
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $lemon_id;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $fertil;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $Lemon;
    
    
        
    use \Face\Traits\EntityFaceTrait;
    
    public static function __getEntityFace() {
    
        return [
            "sqlTable"=>"seed",
            
            "elements"=>[            

                "id"=>[
                    "identifier"=>true,
                    "sql"=>[
                        "isPrimary" => true,
                    ],
                ],
                

                "lemon_id"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "fertil"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                
                "Lemon"=>[
                    "property"=>"Lemon",
                    "class"=>"Lemon",
                    "relation"=>"belongsTo",
                    "relatedBy"=>"Seed",
                    "sql"=>[
                    "join" => ["lemon_id"=>"id"]
                    ],
                ],
                
                
                
            ]
        ];
    
    }

}