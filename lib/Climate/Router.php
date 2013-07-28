<?php

/**
 * @license See LICENSE
 */

namespace Climate;

use Climate\Exception\RouteConfigException;

use Climate\Exception\NoRouteFoundException;

class Router{
    
    protected $routes;
    
    /**
     * construct a new router with the given routes
     * @param array $routes
     */
    public function __construct($routes) {
        $this->routes=$routes;
    }
    
    /**
     * 
     * @param type $args
     * @return type
     * @throws RouteConfigException
     * @throws Exception\BadOptionException
     * @throws NoRouteFoundException
     */
    public function route($args){

        if(!isset($this->routes["default"])){
            throw new RouteConfigException("Given route has no default. Default should be the root of the route");
        }
        
        $it=new \ArrayIterator($args);
        $route=$this->routes["default"];
        $routeName='default';
        $params=array();
        
        while($it->valid()){
            $current=$it->current();
            

            
            if("-" === $current{0}){
                //OPTION CASE
                if("-" === $current{1}){
                    // NAMED OPTION CASE
                }else{
                    // SINGLE OPTION CASE   // TODO loop on each char
                    
                    $optionName=ltrim($current,"-"); // remove the -  "-e" becomes "e"
                    
                    
                    // Look whether or not the option exists
                    if(isset($route['options']) && isset($route['options'][$optionName])){
                        $it->next();
                        
                        // look if the option has a value    //todo look in the config if the option needs a value
                        if(!$it->valid())
                            throw new Exception\BadOptionException("option $current has no value");
                            
                        $optionValue=$it->current();
                        
                        
                        // option maybe needs a to match a type. Look if so
                        if(isset($route['options'][$optionName]['type'])){
                            switch(strtolower($route['options'][$optionName]['type'])){
                                case "int":

                                    if(!\Peek\Utils\ValuesUtils::isInt($optionValue))
                                        throw new Exception\BadOptionException("option $current needs an integer as value, ".var_export($optionValue,true)." given");
                                    break;
                                    
                                case "string":
                                    // EVERYTIME A STRING
                                    break;
                                
                                case "natural": // positive int
                                    if(!\Peek\Utils\ValuesUtils::isInt($optionValue) && $optionValue<0)
                                        throw new Exception\BadOptionException("option $current needs to be a [positive integer or 0], ".var_export($optionValue,true)." given");
                                    break;
                                    
                                case "nz-natural": // gt zero int
                                    if(!\Peek\Utils\ValuesUtils::isInt($optionValue) || $optionValue<1)
                                        throw new Exception\BadOptionException("option $current needs to be a [greater than 0 integer], ".var_export($optionValue,true)." given");
                                    break;
                                    
                                default:
                                    throw new RouteConfigException("type '".$route['options'][$optionName]['type']."' was configured of option $current, but this type is not a valid type. Valid types are : int, string, bool ");
                            
                            }
                        }
                        
                        $route['options'][$optionName]['default']=$optionValue;
                        

                    }else{
                        throw new Exception\BadOptionException("option $current is not a valid option");
                    }
                            
                }
            }else{
                
                // COMMAND CASE
                
                if(!isset($route['children'][$current]))
                    throw new NoRouteFoundException("$current is not a valid Operation");
                
                if(isset($route["options"])){
                    foreach ($route["options"] as $name=>$opt){
                        if( ! isset($opt['default']))
                            throw new Exception\BadOptionException("Option -$name was omited, -$name is needed");

                        $params[$name]=$opt['default'];

                    }
                }
                
                
                $route=$route['children'][$current];
                $routeName=$current;
            }
            
            
            $it->next();
        }
        
        
        if(isset($route["options"])){
            foreach ($route["options"] as $name=>$opt){
                if( ! isset($opt['default']))
                    throw new Exception\BadOptionException("Option -$name was omited, -$name is needed");

                $params[$name]=$opt['default'];

            }
        }
        
        
            
        if(!isset($route['controller']))
            throw new RouteConfigException($routeName." has no controller");
        
        if(!isset($route['action']))
            throw new RouteConfigException($routeName." has no action");
        
        $controller=$route['controller'];
        $action=$route['action'];
                
        
        return array("controller"=>$controller,"action"=>$action,"params"=>$params);
    }
    
}