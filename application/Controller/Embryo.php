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