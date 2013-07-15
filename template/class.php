<?php echo "<?php";

    //TODO PLACE IT IN THE COLUMN SUB OBJECT

    $filterChain = new Zend\Filter\FilterChain();
    $filterChain->attach(new Zend\Filter\Word\UnderscoreToCamelCase());
    $filterChain->attach(new \Zend\Filter\Word\DashToCamelCase());

?>

<?php if($namespace){ ?>        
namespace <?= $namespace ?>;
<?php } ?>
    
class <?= $class ?> {

    <?php foreach ($columns as $column){ /* @var $column \Model\Columns */ ?>
    
    /**
     *
     */
    // TODO TYPE + COMMENT + ENTITY SI BESOIN
    protected $<?= lcfirst($filterChain->filter($column->getColumn_name())) ?>;
    

    <?php } ?>
    
    <?php if($accessors){ ?>  
        <?php foreach ($columns as $column){ /* @var $column \Model\Columns */ ?>

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
            <?php if($fluentSetter){ ?>
            return $this;
            <?php } ?>
        }

        <?php } ?>
    <?php } ?>
        
    use \Face\Traits\EntityFaceTrait;
    
    public static function __getEntityFace() {
    
        return [
            "sqlTable"=>"TODO",
            
            "elements"=>[
            
                <?php foreach ($columns as $column){ /* @var $column \Model\Columns */ ?>

                   
                "<?= $column->getColumn_name() ?>"=>[
                    "identifier"=>true,
                    "sql"=>[
                        "isPrimary" => true
                    ]
                ],

                <?php } ?>
            
            
            
            ]
        ];
    
    }

}