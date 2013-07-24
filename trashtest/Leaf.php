<?php
    
class Leaf {
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $length;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $tree_id;
    
    
        
    use \Face\Traits\EntityFaceTrait;
    
    public static function __getEntityFace() {
    
        return [
            "sqlTable"=>"leaf",
            
            "elements"=>[            

                "id"=>[
                    "identifier"=>true,
                    "sql"=>[
                        "isPrimary" => true,
                    ],
                ],
                

                "length"=>[
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