<?php
    
class ReservationType {
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_location_type;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $label;
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
    
    
        
    use \Face\Traits\EntityFaceTrait;
    
    public static function __getEntityFace() {
    
        return [
            "sqlTable"=>"reservation_type",
            
            "elements"=>[            

                "id_location_type"=>[
                    "identifier"=>true,
                    "sql"=>[
                        "isPrimary" => true,
                    ],
                ],
                

                "label"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                
                "Image"=>[
                    "property"=>"Image",
                    "class"=>"Image",
                    "relation"=>"hasMany",
                    "relatedBy"=>"ReservationType",
                    "sql"=>[
                    "join" => ["id_location_type"=>"id_reservation_type"]
                    ],
                ],
                
                "Reservation"=>[
                    "property"=>"Reservation",
                    "class"=>"Reservation",
                    "relation"=>"hasMany",
                    "relatedBy"=>"ReservationType",
                    "sql"=>[
                    "join" => ["id_location_type"=>"id_location_type"]
                    ],
                ],
                
                
                
            ]
        ];
    
    }

}