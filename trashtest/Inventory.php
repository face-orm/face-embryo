<?php
    
class Inventory {
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $id_inventory;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $InventoryItem;
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $Reservation;
    
    
        
    use \Face\Traits\EntityFaceTrait;
    
    public static function __getEntityFace() {
    
        return [
            "sqlTable"=>"inventory",
            
            "elements"=>[            

                "id_inventory"=>[
                    "identifier"=>true,
                    "sql"=>[
                        "isPrimary" => true,
                    ],
                ],
                
                "InventoryItem"=>[
                    "property"=>"InventoryItem",
                    "class"=>"InventoryItem",
                    "relation"=>"hasMany",
                    "relatedBy"=>"Inventory",
                    "sql"=>[
                    "join" => ["id_inventory"=>"id_inventory"]
                    ],
                ],
                
                "Reservation"=>[
                    "property"=>"Reservation",
                    "class"=>"Reservation",
                    "relation"=>"hasMany",
                    "relatedBy"=>"Inventory",
                    "sql"=>[
                    "join" => ["id_inventory"=>"id_inventory"]
                    ],
                ],
                
                
                
            ]
        ];
    
    }

}