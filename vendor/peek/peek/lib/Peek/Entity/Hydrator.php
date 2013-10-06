<?php

namespace Peek\Entity;

/**
 * Description of Hydrator
 *
 * @author sghzal
 */
class Hydrator {
    
    // TODO VALIDATE DATAS
    // TODO ALLOW [CONTINUE ON NOT VALID] CONFIG
    // TODO ERRORS REPPORT
    
    public function hydrate($object,$map,$values){
        
        if(is_a($map, "Peek\Entity\Navigator"))
            $n=$map;
        else
            $n=new Navigator($map);

        foreach($values as $fieldPath=>$value){

            $n->set($fieldPath, $object, $value);
        }
        
    }
    
}
