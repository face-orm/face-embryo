<?php echo "<?php";

/* @var $class \Face\Core\EntityFace */

?>

<?php if($namespace){ ?>        
namespace <?= $class->getNamespace() ?>;
<?php } ?>
    
class <?= $class->getClass() ?> {
<?php 
foreach ($class->getElements() as $column){ /* @var $column \Face\Core\EntityFaceElement */ 
   
    ?><?php if($column->isEntity()){ ?>
    /**
     * @var \<?= $column->getClass() ?> 
     */
<?php } ?>
    protected $<?= $column->getPropertyName() ?>;
<?php 
} 
?>
    
    

<?php foreach ($class->getElements() as $column){ /* @var $column \App\DbProperty */ ?>

<?php     if($column->isEntity()){ ?>
    /**
     * @return \<?= $column->getClass() ?> 
     */
<?php     } ?>
    public function get<?= ucfirst($column->getPropertyName()) ?>(){
        return $this-><?= $column->getPropertyName() ?>;
    }

    public function set<?= ucfirst($column->getPropertyName()) ?>($value){
        $this-><?= $column->getPropertyName() ?>=$value;
<?php         if($fluentSetter){ ?>return $this;<?php } ?>
    }

<?php } ?>

    use \Face\Traits\EntityFaceTrait;
    
    public static function __getEntityFace() {
    
        return [
            "sqlTable"=>"<?= $class->getSqlTable() ?>",
            
            "elements"=>[            
<?php foreach ($class->getElements() as $column){ /* @var $column \Face\Core\EntityFaceElement */ ?>
<?php if($column->isValue()){ ?>

                "<?= $column->getSqlColumnName() ?>"=>[
                    "identifier"=><?= $column->getIsIdentifier()?"true":"false" ?>,
                    "sql"=>[
                        "isPrimary" => <?= $column->getSqlIsPrimary()?"true":"false" ?>,
                    ],
                ],
<?php }else{ ?>
                "<?= $column->getName() ?>"=>[
                    "property"=>"<?= $column->getPropertyName() ?>",
                    "class"=>"<?= $column->getClass() ?>",
                    "relation"=>"<?= $column->getRelation() ?>",
                    "relatedBy"=>"<?= $column->getRelatedBy() ?>",
                    "sql"=>[
                    "join" => ["<?= key( $column->getSqlJoin() )?>"=>"<?= current( $column->getSqlJoin() )?>"]
                    ],
                ],
<?php } ?>
                
<?php } ?>
                
                
            ]
        ];
    
    }

}