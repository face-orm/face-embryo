<?php

namespace Controller;

/**
 * Description of Default
 *
 * @author bobito
 */
class Embryo extends \Climate\Controller{

    public function generateOld(){

        $host = $this->h;
        $user = $this->u;
        $pswd = $this->p;
        $db   = $this->d;

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
        

        // LIST OF THE THE CLASS :: 1 CLASS = 1 TABLE (except through tables
        $classes=array();
        $throughTables = array();
        
        
        
        //////////////////////
        // GENERATE PROPERTIES
        foreach($tables as $t){
            
            $isThrough = false;
            
            if(count($t->getColumns()) == 2  && count($t->getForeignKeys()) && count($t->getPrimaries()) == 2 ){
                
                
                
                do{
                    // Ask the user if it is a through relation
                    $tableName = $t->getTable_name();
                    echo PHP_EOL;
                    $question = \Printemps::Color($tableName, "green") . " is a " . \Printemps::Color("ManyToMany", "blue") . " relation table (hasManyThrough) [Y/n] :";
                    if(function_exists("readline"))
                        $input = \readline($question);
                    else if(function_exists("stream_get_line")){
                        echo $question;
                        $input = stream_get_line(STDIN, 1024, PHP_EOL);
                    }else{
                        echo "Readline Not available on your system. Auto set that $tableName is a many to many table (hasManyThrough)";
                        echo PHP_EOL;
                        $input = "y";
                    }

                    if(!$input || strtolower($input) == "y" ){
                        $isThrough = true;
                    }else if(strtolower ($input) == "n"){
                        $isThrough = false;
                    }else{
                        $isThrough = null;
                    }
                }while(null === $isThrough);
                
            }
            
            
            
            if($isThrough){
                // in this case we have a virtual table (no model association). We will have to generate 2 hasManyThrough relatioinships
                
                $throughTables[$t->getTable_name()] = $t;
                
            }else{
                $class=new \Face\Core\EntityFace(null,null);
                $class->setSqlTable($t->getTable_name());

                $class->setClass( ucfirst($filterChain->filter( $t->getTable_name() ) ));


                $classes[$t->getTable_name()]=$class;

                foreach($t->getColumns() as $c){
                    /* @var $c \Model\Columns */

                    $p=new \Face\Core\EntityFaceElement(null,null);
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
        }
        
        
        
        //////////////////////
        // GENERATE ENTITIES
        foreach($tables as $t){
      
            if(!isset($classes[$t->getTable_name()])){
                continue;
            }
            
            foreach($t->getColumns() as $c){
                /* @var $c \Model\Columns */

                
                if($c->getKeyColumnUsages()){
                    foreach ($c->getKeyColumnUsages() as $kcu){
                        /* @var $kcu \Model\KeyColumnUsage */
                            
                        // in this case it is a foreign key
                        if($kcu->getReferencedColumn()){
                            
                            // in this case it referes to a through table then we create a hasManytrough relationship
                            if(isset($throughTables[$kcu->getReferencedColumn()->getTable_name()])){
                                
                                

                                
                                
                            // this is a hasMany or hasOne relation    
                            }else{

                                $face=$classes[$t->getTable_name()];
                                $rFace=$classes[$kcu->getReferencedColumn()->getTable_name()];
                                
                                


                                // TODO look if name/property doesnt already exist
                                $entity = new \Face\Core\EntityFaceElement(null,null);
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

                                    echo PHP_EOL;
                                    $question = \Printemps::Color($referencedTable, "green") 
                                            . \Printemps::Color(" HasMany ", "blue")  
                                            . \Printemps::Color($tableName, "green") ."  ? (Y/n) :";
                                    if(function_exists("readline"))
                                        $input = \readline($question);
                                    else if(function_exists("stream_get_line")){
                                        echo $question;
                                        $input = stream_get_line(STDIN, 1024, PHP_EOL);
                                    }else{
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
        }
        
        // CREATE hasManyThrough relationships
        foreach($throughTables as $t){
            foreach($t->getColumns() as $c){
                if($c->getKeyColumnUsages()){
                    foreach ($c->getKeyColumnUsages() as $kcu){
                        /* @var $kcu \Model\KeyColumnUsage */
                            
                        // we only want foreign keys
                        if($kcu->getReferencedColumn()){
                            
                            $face  = null;
                            $oFace = null;
                            
                            foreach ($t->getForeignKeys() as $kcuO){
                                
                                if($kcuO->getConstraint_name() == $kcu->getConstraint_name()){
                                    $face = $classes[$kcuO->getReferencedColumn()->getTable_name()];
                                }else{
                                    $oFace = $classes[$kcuO->getReferencedColumn()->getTable_name()];
                                }
                            }

              
                            $entity = new \Face\Core\EntityFaceElement(null,null);
                            $entity->setType("entity");
                            $entity->setName($oFace->getClass());  // TODO  : remove namespace
                            $entity->setClass($oFace->getClass());
                            $entity->setPropertyName($oFace->getClass());  // TODO  : remove namespace
                            $entity->setRelation("hasManyThrough");
                            $entity->setSqlThrough($c->getTable_name());
                            $entity->setRelatedBy($face->getClass());// TODO  : remove namespace
                            $entity->setSqlJoin([ $kcu->getReferencedColumn()->getColumn_name() => $kcu->getColumn_name() ]);

                            $face->addElement($entity);
                            
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

        $host = $this->h;
        $user = $this->u;
        $pswd = $this->p;
        $db   = $this->d;

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
                    echo \Printemps::Color(" AUTOINCREMENT","purple");

                echo PHP_EOL;

                if(count($c->getKeyColumnUsages())>0)
                    foreach ($c->getKeyColumnUsages() as $kcu){
                        if($kcu->getReferencedColumn())
                            echo "     ".\Printemps::Color("| ".$kcu->getReferencedColumn()->getTable_name() . "." . $kcu->getReferencedColumn()->getColumn_name(),"yellow").PHP_EOL;
                        else if(strtolower ($kcu->getConstraint_name())=="primary")
                            echo "     ".\Printemps::Color("| PRIMARY", "green",0).PHP_EOL;
                        else if(strtolower ($kcu->getConstraint_name())=="unique")
                            echo "     ".\Printemps::Color("| UNIQUE", "green",0).PHP_EOL;
                        else
                            echo "     ".\Printemps::Color("| ". $kcu->getConstraint_name(), "lblue",0).PHP_EOL;
                    }
                
            }
            
        }
        
    }
    
}