<?php
    
class SiteHasActivity {
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_site_has_activity;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_site;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_activity;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $GeoSite;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $Activity;
    
    
        
    use \Face\Traits\EntityFaceTrait;
    
    public static function __getEntityFace() {
    
        return [
            "sqlTable"=>"site_has_Activity",
            
            "elements"=>[            

                "id_site_has_activity"=>[
                    "identifier"=>true,
                    "sql"=>[
                        "isPrimary" => true,
                    ],
                ],
                

                "id_site"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "id_activity"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                
                "GeoSite"=>[
                    "property"=>"GeoSite",
                    "class"=>"GeoSite",
                    "relation"=>"belongsTo",
                    "relatedBy"=>"SiteHasActivity",
                    "sql"=>[
                    "join" => ["id_site"=>"id_site"]
                    ],
                ],
                
                "Activity"=>[
                    "property"=>"Activity",
                    "class"=>"Activity",
                    "relation"=>"belongsTo",
                    "relatedBy"=>"SiteHasActivity",
                    "sql"=>[
                    "join" => ["id_activity"=>"id_activity"]
                    ],
                ],
                
                
                
            ]
        ];
    
    }

}