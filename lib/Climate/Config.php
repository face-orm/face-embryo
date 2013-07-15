<?php

namespace Climate;

/**
 * Description of ApplicationConfig
 *
 * @author bobito
 */
abstract class Config{
    
    private static $conf;
    
    public static function build($confArray) {
        $c=new Utils\Config(["accessLog","errorLog","routesFile","sendEmailOnError","applicationName","applicationVersion","debugRoutes"]);
        self::$conf=$c;
        $c->build($confArray);
    }
    
    public static function __callStatic($name,$arg) {
        
        $c=self::$conf;
        
        return $c->$name;
        
    }
    
}

?>
