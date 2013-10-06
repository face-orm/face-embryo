<?php

namespace Peek\Entity;

/**
 * Extractor allows to extract data from an object and return a single array according to the given map
 *
 * @author sghzal
 */
class Extractor {
    
    // TODO VALIDATE DATAS
    // TODO ALLOW [CONTINUE ON NOT VALID] CONFIG
    // TODO ERRORS REPPORT
    
    public function Extract($object,$map){
        
        if(is_a($map, "Peek\Entity\Navigator"))
            $n=$map;
        else
            $n=new Navigator($map);
        
        $array=array();

        foreach($values as $fieldPath=>$value){
            
            $piecesOfPath=  explode(".", $fieldPath);
            
            $n->set($fieldPath, $object, $value);
            
        }
        
        return $array;
        
    }
    
}
