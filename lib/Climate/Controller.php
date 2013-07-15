<?php

/**
 * @license See LICENSE
 */

namespace Climate;

/**
 * Description of Controller
 *
 * @author Soufiane GHZAL
 */
class Controller {
    
    private $params;
    
    public function setParams($params){
        $this->params=$params;
    }
    
    public function __get($name) {
        
        
        if(isset($this->params[$name])){
            return $this->params[$name];
        }
        
        throw new \Exception("Trying to get unexisting option : $name");
    }
    
}
