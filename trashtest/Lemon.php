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
    protected $mature;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $tree_id;
    
    
        
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
                

                "mature"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "tree_id"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                
                
                
            ]
        ];
    
    }

}