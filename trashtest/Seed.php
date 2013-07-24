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
    protected $fertil;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $lemon_id;
    
    
        
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
                

                "fertil"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "lemon_id"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                
                
                
            ]
        ];
    
    }

}