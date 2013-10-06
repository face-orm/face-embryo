<?php

namespace Peek\Entity;

/**
 * Navigator allows  to dynamically get or set values 
 *
 * @author sghzal
 */
class Navigator {
    
    protected $map;
    
    // TODO cache literalsPathes into static var
    
    function __construct($map) {
        $this->map = $map;
    }

    /**
     * allow to get a value from an array or an object according to a given path.
     * 
     * e.g you can give an object with a property 'foo' you will want to get it with $myObject->getFoo()
     * then call $navigator->get('foo',$myObject)
     * 
     * e.g you can give an object which contain the above object at the property 'bar'. You want to get foo with :  $myContainer->getBar()->getFoo()
     * then you call $navigator->get('bar.foo',$myContainer)
     * 
     * @param string $path the  path to get
     * @param array|object $searchable the object or array into which we search
     * @return mixed
     */
    public function get($path,$searchable,$ignoreAllow=false ,$allArray=false){ 
        

        if ( $this->isAllowed($path) || $ignoreAllow ){
            
            $piecesOfPath= explode(".", $path);
            
            $actual=$searchable;
            $literalPathMade="";
            
            $i=0;
            foreach($piecesOfPath as $piece){

                // if it is a number, we are in array case
                if( ctype_digit($piece) || $allArray ){ // TODO EXCEPTION ON ARRAY/OBJECT
                    $actual=$actual[$piece];
                }else{ // TODO EXCEPTION ON ARRAY/OBJECT
                    $literalPathMade.=".".$piece;
                    if(isset($this->map[$literalPathMade]["getter"])){
                        $getter=$this->map[$literalPathMade]["getter"];
                        $actual=$actual->$getter();
                    }else{
                        $getter="get".ucfirst($piece);
                        $actual=$actual->$getter();
                    }
                }
                
                // remove the first dot [.] only the first time
                if($i==0){
                    ltrim($literalPathMade,".");
                }
                $i++;
                
                

            }

            return $actual;
        }
        
    }
    
    /**
     * set a value to the given path on a given base object or array
     * @param string $path the path that we want to set
     * @param array|object $searchable the object or array which is base for the path
     * @param mixed $value value to set
     * @param bool $ignoreAllow ignore if the field is not allowed in the map
     */
    public function set($path,$searchable,$value,$ignoreAllow=false,$allArray=false){
        

        if ( $this->isAllowed($path) || $ignoreAllow ){
        
            $lastDot=strrpos($path, ".");
            if($lastDot){

                $queryOn = $this->get(substr( $path , 0 , $lastDot ) , $searchable , true , $allArray);

                $query = trim(strrchr($path, "."),".");

            }else{

                $queryOn = $searchable;
                $query = $path;

            }

            if(isset($this->map[$path]["setter"])){
                $setter=$this->map[$path]["setter"];
                $queryOn->$setter($value);
            }else{
                $setter="set".ucfirst($query);
                $queryOn->$setter($value);
            }
            // TODO array set/get reference to persist the change
        }
    }
    
    public function isAllowed($path){
        return key_exists($this->getLitteralPath($path),$this->map);
    }
    
    public function getLitteralPath($path){
        
        $path=".".$path.".";
        $literalPath=  preg_replace("#\.[0-9]+\.#", ".*.", $path);
        
        return substr($literalPath,1,-1);
        
    }
    
}
