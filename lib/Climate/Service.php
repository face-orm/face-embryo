<?php

namespace Climate;

/**
 * Description of Service
 *
 * @author bobito
 */
class Service {
    
    protected $services;
    
    public function __construct() {
        $this->services=array();
    }
    
    public function registerService($name,  callable $callable){
        $this->services[$name]=[
          "callable"=> $callable,
          "called"  => false,
          "value"    => null
        ];
    }
    
    public function getService($name){
        if(isset($this->services[$name])){
            
            
            if(!$this->services[$name]["called"]){
                
                $this->services[$name]['value']=$this->services[$name]['callable']();
                $this->services[$name]["called"]=true;
                
            }
            
            return $this->services[$name]['value'];
            
        }else{
            
            throw new \Exception("Trying to get an unset service : '$name'");
        
        }
    }
}

?>
