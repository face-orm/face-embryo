<?php
    
class City {
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_city;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_country;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $libelle;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $zipcode;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $google_map_coordinates;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $city_url;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $Country;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $GeoSite;
    
    
        
    use \Face\Traits\EntityFaceTrait;
    
    public static function __getEntityFace() {
    
        return [
            "sqlTable"=>"city",
            
            "elements"=>[            

                "id_city"=>[
                    "identifier"=>true,
                    "sql"=>[
                        "isPrimary" => true,
                    ],
                ],
                

                "id_country"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "libelle"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "zipcode"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "google_map_coordinates"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "city_url"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                
                "Country"=>[
                    "property"=>"Country",
                    "class"=>"Country",
                    "relation"=>"belongsTo",
                    "relatedBy"=>"City",
                    "sql"=>[
                    "join" => ["id_country"=>"id_country"]
                    ],
                ],
                
                "GeoSite"=>[
                    "property"=>"GeoSite",
                    "class"=>"GeoSite",
                    "relation"=>"hasMany",
                    "relatedBy"=>"City",
                    "sql"=>[
                    "join" => ["id_city"=>"id_city"]
                    ],
                ],
                
                
                
            ]
        ];
    
    }

}