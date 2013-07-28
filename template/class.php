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
     * @var type \<?= $column->getClass() ?>
     */
<?php } ?>
    protected $<?= $column->getPropertyName() ?>;
<?php 
} 
?>
    
    
<?php    if($accessors){ ?>  
        <?php foreach ($class->getProperties() as $column){ /* @var $column \App\DbProperty */ ?>

        /**
         *
         */
        // TODO docblok : TYPE + COMMENT + ENTITY SI BESOIN
        public function get<?= $filterChain->filter($column->getColumn_name()) ?>(){
            return $this-><?= lcfirst($filterChain->filter($column->getColumn_name())) ?>;
        }

        /**
         *
         */
        // TODO docblok : TYPE + COMMENT + ENTITY SI BESOIN
        public function set<?= $filterChain->filter($column->getColumn_name()) ?>($value){
            $this-><?= lcfirst($filterChain->filter($column->getColumn_name())) ?>=$value;
            <?php if($fluentSetter){ ?>return $this;<?php } ?>
        }

        <?php } ?>
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