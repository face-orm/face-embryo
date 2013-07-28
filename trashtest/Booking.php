<?php
    
class Booking {
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_booking;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_user;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_location_range;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_billing_address;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $date;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $User;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $LocationRange;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $BillingAddress;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $BookingParticipant;
    
    
        
    use \Face\Traits\EntityFaceTrait;
    
    public static function __getEntityFace() {
    
        return [
            "sqlTable"=>"booking",
            
            "elements"=>[            

                "id_booking"=>[
                    "identifier"=>true,
                    "sql"=>[
                        "isPrimary" => true,
                    ],
                ],
                

                "id_user"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "id_location_range"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "id_billing_address"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                

                "date"=>[
                    "identifier"=>false,
                    "sql"=>[
                        "isPrimary" => false,
                    ],
                ],
                
                "User"=>[
                    "property"=>"User",
                    "class"=>"User",
                    "relation"=>"belongsTo",
                    "relatedBy"=>"Booking",
                    "sql"=>[
                    "join" => ["id_user"=>"id_user"]
                    ],
                ],
                
                "LocationRange"=>[
                    "property"=>"LocationRange",
                    "class"=>"LocationRange",
                    "relation"=>"belongsTo",
                    "relatedBy"=>"Booking",
                    "sql"=>[
                    "join" => ["id_location_range"=>"id_location_range"]
                    ],
                ],
                
                "BillingAddress"=>[
                    "property"=>"BillingAddress",
                    "class"=>"BillingAddress",
                    "relation"=>"belongsTo",
                    "relatedBy"=>"Booking",
                    "sql"=>[
                    "join" => ["id_billing_address"=>"id_billing_address"]
                    ],
                ],
                
                "BookingParticipant"=>[
                    "property"=>"BookingParticipant",
                    "class"=>"BookingParticipant",
                    "relation"=>"hasMany",
                    "relatedBy"=>"Booking",
                    "sql"=>[
                    "join" => ["id_booking"=>"id_booking"]
                    ],
                ],
                
                
                
            ]
        ];
    
    }

}