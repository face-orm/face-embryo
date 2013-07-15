<?php

/**
 * @license See LICENSE
 */

namespace Climate\Utils;
/**
 * Description of Config
 *
 * @author Soufiane GHZAL
 */
class Config {
    
    private $neededConfigs;
    private $config=[];

    
    
    public function __construct($neededConfigs) {
        $this->neededConfigs=$neededConfigs;
    }
    
    public function build($configArray){
        
        $this->config=[];
        
        foreach($this->neededConfigs as $conf){
            if(!isset($configArray[$conf]))
                throw new \Exception ("Config $conf is missing");
        }
        
        $this->config=$configArray;
    }
    
    public function __get($name) {
        
        if(!isset($this->config[$name]))
            return null;
        
        return $this->config[$name];
        
    }
    
}

?>
