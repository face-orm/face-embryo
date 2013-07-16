<?php echo "<?php";

/* @var $class \App\DbClass */

?>

<?php if($class->getNamespace()){ ?>        
namespace <?= $class->getNamespace() ?>;
<?php } ?>
    
class <?= $class->getCamelClassName() ?> {
<?php foreach ($class->getProperties() as $column){ /* @var $column \App\DbProperty */ ?>
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $<?= $column->getColumnName() ?>;
<?php } ?>
    
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
            "sqlTable"=>"<?= $class->getTableName() ?>",
            
            "elements"=>[            
<?php foreach ($class->getProperties() as $column){ /* @var $column \App\DbProperty */ ?>

                "<?= $column->getColumnName() ?>"=>[
                    "identifier"=><?= $column->getIsPrimary()?"true":"false" ?>,
                    "sql"=>[
                        "isPrimary" => <?= $column->getIsPrimary()?"true":"false" ?>,
                    ],
                ],
<?php } ?>

<?php foreach ($class->getEntities() as $relation){ /* @var $relation \App\DbRelation */ ?>

                "<?= $relation->getReferencedColumn()->getColumnName() ?>"=>[
                    "identifier"=><?= $relation->getName()?"true":"false" ?>,
                    "sql"=>[
                        "isPrimary" => <?= $relation->getName()?"true":"false" ?>,
                    ],
                ],
<?php } ?>
                
                
            ]
        ];
    
    }

}