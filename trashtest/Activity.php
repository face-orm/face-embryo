<?php
    
class Activity {
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_activity;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $libelle;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $image;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $SiteHasActivity;
    
    
        
    use \Face\Traits\EntityFaceTrait;
    
    public static function __getEntityFace() {
    
        return [
            "sqlTable"=>"activity",
            
            "elements"=>[            

                "id_activity"=>[
                    "identifier"=>true,
                    "sql"=>[
                        "isPrimary" => true,
                    ],
                ],
                

                "libelle"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "image"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                
                "SiteHasActivity"=>[
                    "property"=>"SiteHasActivity",
                    "class"=>"SiteHasActivity",
                    "relation"=>"hasMany",
                    "relatedBy"=>"Activity",
                    "sql"=>[
                    "join" => ["id_activity"=>"id_activity"]
                    ],
                ],
                
                
                
            ]
        ];
    
    }

}