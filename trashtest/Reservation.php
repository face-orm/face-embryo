<?php
    
class Reservation {
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_reservation;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_site;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_location_type;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $min_people;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $max_people;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_inventory;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $LocationRange;
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
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $Inventory;
    
    
        
    use \Face\Traits\EntityFaceTrait;
    
    public static function __getEntityFace() {
    
        return [
            "sqlTable"=>"reservation",
            
            "elements"=>[            

                "id_reservation"=>[
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
                

                "id_location_type"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "min_people"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "max_people"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "id_inventory"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                
                "LocationRange"=>[
                    "property"=>"LocationRange",
                    "class"=>"LocationRange",
                    "relation"=>"hasMany",
                    "relatedBy"=>"Reservation",
                    "sql"=>[
                    "join" => ["id_reservation"=>"id_location"]
                    ],
                ],
                
                "GeoSite"=>[
                    "property"=>"GeoSite",
                    "class"=>"GeoSite",
                    "relation"=>"belongsTo",
                    "relatedBy"=>"Reservation",
                    "sql"=>[
                    "join" => ["id_site"=>"id_site"]
                    ],
                ],
                
                "ReservationType"=>[
                    "property"=>"ReservationType",
                    "class"=>"ReservationType",
                    "relation"=>"belongsTo",
                    "relatedBy"=>"Reservation",
                    "sql"=>[
                    "join" => ["id_location_type"=>"id_location_type"]
                    ],
                ],
                
                "Inventory"=>[
                    "property"=>"Inventory",
                    "class"=>"Inventory",
                    "relation"=>"belongsTo",
                    "relatedBy"=>"Reservation",
                    "sql"=>[
                    "join" => ["id_inventory"=>"id_inventory"]
                    ],
                ],
                
                
                
            ]
        ];
    
    }

}