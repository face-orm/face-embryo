<?php

namespace Controller;

/**
 * Description of Default
 *
 * @author bobito
 */
class Embryo extends \Climate\Controller{

    public function generate(){
        
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
                echo "  | ".$c->getColumn_name()."::".count($c->getKeyColumnUsages()).PHP_EOL;

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