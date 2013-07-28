<?php
    
class Image {
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_image;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $name;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $extension;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $title;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_geo_site;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_reservation_type;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $GeoSite;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $ReservationType;
    
    
        
    use \Face\Traits\EntityFaceTrait;
    
    public static function __getEntityFace() {
    
        return [
            "sqlTable"=>"image",
            
            "elements"=>[            

                "id_image"=>[
                    "identifier"=>true,
                    "sql"=>[
                        "isPrimary" => true,
                    ],
                ],
                

                "name"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "extension"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "title"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "id_geo_site"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "id_reservation_type"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                
                "GeoSite"=>[
                    "property"=>"GeoSite",
                    "class"=>"GeoSite",
                    "relation"=>"belongsTo",
                    "relatedBy"=>"Image",
                    "sql"=>[
                    "join" => ["id_geo_site"=>"id_site"]
                    ],
                ],
                
                "ReservationType"=>[
                    "property"=>"ReservationType",
                    "class"=>"ReservationType",
                    "relation"=>"belongsTo",
                    "relatedBy"=>"Image",
                    "sql"=>[
                    "join" => ["id_reservation_type"=>"id_location_type"]
                    ],
                ],
                
                
                
            ]
        ];
    
    }

}