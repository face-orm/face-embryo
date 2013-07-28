<?php
    
class GeoSite {
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_site;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_city;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_groupe_site;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $name;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $subname;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $show_home;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $actif;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $short_description;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $long_description;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $site_url;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $City;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $GroupeSite;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $Image;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $Reservation;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $SiteHasActivity;
    
    
        
    use \Face\Traits\EntityFaceTrait;
    
    public static function __getEntityFace() {
    
        return [
            "sqlTable"=>"geo_site",
            
            "elements"=>[            

                "id_site"=>[
                    "identifier"=>true,
                    "sql"=>[
                        "isPrimary" => true,
                    ],
                ],
                

                "id_city"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "id_groupe_site"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "name"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "subname"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "show_home"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "actif"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "short_description"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "long_description"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "site_url"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                
                "City"=>[
                    "property"=>"City",
                    "class"=>"City",
                    "relation"=>"belongsTo",
                    "relatedBy"=>"GeoSite",
                    "sql"=>[
                    "join" => ["id_city"=>"id_city"]
                    ],
                ],
                
                "GroupeSite"=>[
                    "property"=>"GroupeSite",
                    "class"=>"GroupeSite",
                    "relation"=>"belongsTo",
                    "relatedBy"=>"GeoSite",
                    "sql"=>[
                    "join" => ["id_groupe_site"=>"id_groupe_site"]
                    ],
                ],
                
                "Image"=>[
                    "property"=>"Image",
                    "class"=>"Image",
                    "relation"=>"hasMany",
                    "relatedBy"=>"GeoSite",
                    "sql"=>[
                    "join" => ["id_site"=>"id_geo_site"]
                    ],
                ],
                
                "Reservation"=>[
                    "property"=>"Reservation",
                    "class"=>"Reservation",
                    "relation"=>"hasMany",
                    "relatedBy"=>"GeoSite",
                    "sql"=>[
                    "join" => ["id_site"=>"id_site"]
                    ],
                ],
                
                "SiteHasActivity"=>[
                    "property"=>"SiteHasActivity",
                    "class"=>"SiteHasActivity",
                    "relation"=>"hasMany",
                    "relatedBy"=>"GeoSite",
                    "sql"=>[
                    "join" => ["id_site"=>"id_site"]
                    ],
                ],
                
                
                
            ]
        ];
    
    }

}