<?php

namespace Controller;

/**
 * Description of Default
 *
 * @author bobito
 */
class Embryo extends \Climate\Controller{

    public function generateOld(){
        
        $fQ=\Model\Tables::faceQueryBuilder();
        $fQ->join("columns");
        $fQ->join("columns.keyColumnUsages");
        $fQ->join("columns.keyColumnUsages.referencedColumn");
        $fQ->where("~table_schema=:name");
        $fQ->bindValue(":name","lesvacsophie");

        
        $tables=\Climate\Application::service("ORM")->execute($fQ);
        
        /* @var $tables \Face\Sql\Result\ResultSet */

        
        
        //echo $fQ->getSqlString();

        $classes=array();
        
        foreach($tables as $t){
            
            $class=new \App\DbClass();
            $class->setTableName($t->getTable_name());
            
            $classes[$t->getTable_name()]=$class;
      
            foreach($t->getColumns() as $c){
                /* @var $c \Model\Columns */

                $p=new \App\DbProperty();
                $p->setColumnName($c->getColumn_name());

                $classes[$t->getTable_name()]->addProperty($p);
                if($c->getKeyColumnUsages()){
                    foreach ($c->getKeyColumnUsages() as $kcu){
                        if($kcu->getReferencedColumn()){
                           $cr=$kcu->getReferencedColumn();
                           $p2=new \App\DbProperty();
                           $p2->setColumnName($cr->getColumn_name());
                           $r=new \App\DbRelation();
                           $r->setReferencingColumn($p);
                           $r->setReferencedColumn($p2);
                           $classes[$t->getTable_name()]->addEntity($r);
                        }else if(  strtolower($kcu->getConstraint_name())=="primary"  ){
                           $p->setIsPrimary(true);
                        }


                    }
                }
            }
        }
        
        

        
        foreach($classes as $class){
            /* @var $class \App\DbClass */
            $file=fopen("trashtest/".$class->getCamelClassName().".php", "w+");
            ob_start();
            include "template/class.php";
            $content = ob_get_contents();
            ob_end_clean();
            fwrite($file, $content);
            fclose($file);
        }

        
    }
    
    
    
    
    
    public function generate(){
        
        $host = $this->h;
        $user = $this->u;
        $pswd = $this->p;
        $db   = $this->d;
        $output= rtrim($this->o,"/");
        if ($output{0} != "/") {
            $output=  \Climate\Application::$baseDir."/$output";
        }
        
        //////////////////////
        // CREATE THE QUERY
        $fQ=\Model\Tables::faceQueryBuilder();
        $fQ->join("columns");
        $fQ->join("columns.keyColumnUsages");
        $fQ->join("columns.keyColumnUsages.referencedColumn");
        $fQ->where("~table_schema=:name");
        $fQ->bindValue(":name",$db);

        $pdo=new \PDO("mysql:host=$host;dbname=information_schema",$user, $pswd);
        
        //////////////////////
        // EXECUTE THE QUERY
        $tables=  \Face\ORM::execute($fQ, $pdo);
        /* @var $tables \Face\Sql\Result\ResultSet */

        
        //////////////////////
        // CREATE THE FILTER TO CONVERT UNDERSCORED/DASHED TABLE/COLUMN NAMES TO CAMELCASE
        $filterChain = new \Zend\Filter\FilterChain();
        $filterChain->attach(new \Zend\Filter\Word\UnderscoreToCamelCase());
        $filterChain->attach(new \Zend\Filter\Word\DashToCamelCase());
        

        // LIST OF THE THE CLASS :: 1 CLASS = 1 TABLE
        $classes=array();
        
        
        //////////////////////
        // GENERATE PROPERTIES
        foreach($tables as $t){
            
            $class=new \Face\Core\EntityFace();
            $class->setSqlTable($t->getTable_name());
            
            $class->setClass( ucfirst($filterChain->filter( $t->getTable_name() ) ));
            
            
            $classes[$t->getTable_name()]=$class;
      
            foreach($t->getColumns() as $c){
                /* @var $c \Model\Columns */

                echo $c->getColumn_name().PHP_EOL;
                
                $p=new \Face\Core\EntityFaceElement();
                $p->setSqlColumnName($c->getColumn_name());
                $p->setPropertyName($p->getSqlColumnName());
                $p->setType("value");
                $p->setName($p->getSqlColumnName());
                $p->setSqlAutoIncrement($c->getExtra()=="auto_increment");
                
                
                if($c->getKeyColumnUsages()){
                    foreach ($c->getKeyColumnUsages() as $kcu){
                        if(  strtolower($kcu->getConstraint_name())  ==  "primary"  ){
                           $p->setSqlIsPrimary(true);
                           $p->setIsIdentifier(true);
                        }
                    }
                }
                
                $classes[$t->getTable_name()]->addElement($p);
                
                
            }
        }
        
        
        
        //////////////////////
        // GENERATE ENTITIES
        foreach($tables as $t){
      
            foreach($t->getColumns() as $c){
                /* @var $c \Model\Columns */

                
                if($c->getKeyColumnUsages()){
                    foreach ($c->getKeyColumnUsages() as $kcu){
                        /* @var $kcu \Model\KeyColumnUsage */
                        if($kcu->getReferencedColumn()){
                           
  
                            
                            $face=$classes[$t->getTable_name()];
                            $rFace=$classes[$kcu->getReferencedColumn()->getTable_name()];
                            
                            
                            // TODO look if name/property doesnt already exist
                            $entity = new \Face\Core\EntityFaceElement();
                            $entity->setType("entity");
                            $entity->setName($rFace->getClass());  // TODO  : remove namespace
                            $entity->setClass($rFace->getClass());
                            $entity->setPropertyName($rFace->getClass());  // TODO  : remove namespace
                            $entity->setRelation("belongsTo");
                            
                            $rEntity = new \Face\Core\EntityFaceElement();
                            $rEntity->setType("entity");
                            $rEntity->setName($face->getClass()); // TODO  : remove namespace
                            $rEntity->setClass($face->getClass());
                            $rEntity->setPropertyName($face->getClass()); // TODO  : remove namespace
                            
                            
                            
                            $tableName = $kcu->getTable_name();
                            $referencedTable=$kcu->getReferencedColumn()->getTable_name();
                            
                            //////////////////////////////////////////
                            // PROMPT THE USER IF HAS ONE OR HAS MANY
                            do{

                                if(function_exists("readline"))
                                    $input = \readline("$referencedTable has many $tableName ? (Y/n) ");
                                else{
                                    echo "Readline Not available on your system. Auto set that " . $rEntity->getName() . " hasMany " . $entity->getName() ;
                                    echo PHP_EOL;
                                    $input = "y";
                                }

                                if($input=="")
                                    $input="y";
                                else
                                    $input=  strtolower ($input);
                                
                                if($input=="y")
                                    $relation = "hasMany";
                                else if($input=="n")
                                    $relation = "hasOne";
                                else
                                    $relation = null;
                               
                                
                                
                            }while( $relation == null );
                            
                            $rEntity->setRelation($relation);

                            $entity->setRelatedBy($rEntity->getName());
                            $rEntity->setRelatedBy($entity->getName());
                            
                            
                            $idColumn=$kcu->getColumn_name();
                            $rIdColumn=$kcu->getReferencedColumn()->getColumn_name();
                            
                            $entity->setSqlJoin([$idColumn=>$rIdColumn]);
                            $rEntity->setSqlJoin([$rIdColumn=>$idColumn]);
                            
                            $face->addElement($entity);
                            $rFace->addElement($rEntity);
                            
                           
                        }
                    }
                }
                
                
            }
        }
        
        

        
        foreach($classes as $class){
            /* @var $class \Face\Core\EntityFace */
            $file=fopen("$output/".$class->getClass().".php", "w+"); // TODO : psr-0 structure
            ob_start();
            include "template/class.php";
            $content = ob_get_contents();
            ob_end_clean();
            fwrite($file, $content);
            fclose($file);
        }

        
    }
    
    
    
    
    public function view(){
        
        $fQ=\Model\Tables::faceQueryBuilder();
        $fQ->join("columns");
        $fQ->join("columns.keyColumnUsages");
        $fQ->join("columns.keyColumnUsages.referencedColumn");
        $fQ->where("~table_schema=:name");
        $fQ->bindValue(":name","lesvacsophie");

        
        $tables=\Climate\Application::service("ORM")->execute($fQ);
        
        //echo $fQ->getSqlString();

        foreach($tables as $t){
            echo($t->getTable_name().PHP_EOL);
            
            foreach($t->getColumns() as $c){
                // column name
                echo "  | ".$c->getColumn_name();
                // number of column usages
                if(count($c->getKeyColumnUsages())>0)
                    echo "::".count($c->getKeyColumnUsages());
                // is autoinc
                if($c->getExtra()=="auto_increment")
                    echo \Printemps::Color(" AUTOINCREMENT","green");

                echo PHP_EOL;

                
                foreach ($c->getKeyColumnUsages() as $kcu){
                    if($kcu->getReferencedColumn())
                        echo "     ".\Printemps::Color("| ".$kcu->getReferencedColumn()->getTable_name() . "." . $kcu->getReferencedColumn()->getColumn_name(),"yellow").PHP_EOL;
                    else if(strtolower ($kcu->getConstraint_name())=="primary")
                        echo "     ".\Printemps::Color("| PRIMARY", "green",0).PHP_EOL;
                    else 
                        echo "unknown".PHP_EOL;
                }
                
            }
            
        }
        
    }
    
}