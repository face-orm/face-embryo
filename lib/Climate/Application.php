<?php

/**
 * @license See LICENSE
 */

namespace Climate;

use Symfony\Component\Yaml\Parser as yamlParser;

/**
 * Application starter class.
 *
 * @author Soufiane GHZAL
 */
class Application {
    
    /**
     * args given when calling the application
     * @var array 
     */
    protected static $args;
    
    /**
     * the routeur config
     * @var \Climate\Router
     */
    protected static $routeur;
    
    /**
     * Global climat configs
     * @var ApplicationConfig
     */
    protected static $ClimateConfig;
    
    /**
     * Global configs of the application
     * @var Config
     */
    protected static $config;
    
    public static $baseDir;


    protected static $services;
    
    public static function init($args, \Climate\Router $router){
        
        self::$args=$args;
        self::$routeur=$router;
        self::$services=new Service();
        
    }

    public static function start(){
        
        try{
            
            
            $params=self::$routeur->route(self::$args);
            
            $className  = "\\Controller\\".$params['controller'];
            $action     = $params['action'];
            
            
            /**=======================
             *      DEBUG MODE       =
             * stops the application =
             *************************/
            if("yes" === Config::debugRoutes()){
                self::debugMode($params);
            }

            
            
            
            if(class_exists($className)){
                $c=new $className();
                if(is_a($c, "\Climate\Controller")){
                    if(method_exists($className, $action)){
                            // EXECUTE $c->$action(); after the try catch. 
                            // Then if an error happens, the error will be handled by the error/Exception Handler
                    }else{
                        throw new \Climate\Exception\RouteConfigException("Method $action doesnt exists in $className");
                    }
                }else{
                    throw new \Climate\Exception\RouteConfigException("Class $className doesnt extend \Climate\Controller");
                }
            }else{
                throw new \Climate\Exception\RouteConfigException("Class $className doesnt exists.");
            }
            
        }  catch (\Climate\Exception\RouteConfigException $e){
            
            echo "An error has happened with the route configuration :".PHP_EOL;
            echo $e->getMessage().PHP_EOL;
            self::stop();
            
        } catch (\Exception $e){
            
            echo "Command invalid :".PHP_EOL;
            echo $e->getMessage().PHP_EOL;
            self::stop();
            
        }
        
        
        
        $c->setParams($params['params']);
        $c->$action();
        
        self::stop();
    }
    
    
    
    public static function stop($output=null){
        echo PHP_EOL;
        exit();
    }
    
    
    
    public static function stopOnError($message=""){
        
        print "Script was interrupted by an error. Consult the logs for furthers informations";
        
        self::stop(null," with an error.");
    }
    

    /**
     * set the user config of the application
     * @param \Climate\Config $conf
     */
    public static function setConfig(Config $conf){
        self::$config=$conf;
    }
    
    /**
     * get the asked config from the user config
     * @param string $confName name of the user config to get
     * @return mixed value of the config or null if asked config doesnt exist
     */
    public static function conf($confName){
        return self::$config->$confName;
    }
    
    /**
     * set the climate config.
     * @param \Climate\ClimateConfig $conf
     */
    public static function setClimateConfig(ClimateConfig $conf){
        self::$ClimateConfig=$conf;
    }
    
    /**
     * get the asked config from the climate config
     * @param string $confName name of the user config to get
     * @return mixed value of the config or null if asked config doesnt exist
     */
    public static function ClimateConf($confName){
        return self::$ClimateConfig->$confName;
    }
    
    /**
     * get the asked service
     * @param string $name the asked service
     * @return mixed the service
     * @throws \Climate\Exception service doesnt exist
     */
    public static function service($name){
        $s=self::$services;
        
        try{
            return $s->getService($name);
        } catch (Exception $e){
            throw $e;
        }
    }
    
    public static function registerService($name, callable $callable){
        
        $s=self::$services;
        $s->registerService($name,$callable);
        
    }

    public static function debugMode($params){
        
        $className  = "\\Controller\\".$params['controller'];
        $action     = $params['action'];


        /**=====================
         *     DEBUG MODE      =
         * stops after routing =
         ***********************/
        if("yes" === Config::debugRoutes()){

            $col=new \Colors\Color;

            $c=new \Colors\Color();

            echo PHP_EOL;            
            echo "    ========================================";
            echo PHP_EOL;            
            echo PHP_EOL;            
            echo "       RUNNING APPLICATION IN DEBUG MODE";
            echo PHP_EOL;            
            echo PHP_EOL;            
            echo "    ========================================";
            echo PHP_EOL;            
            echo PHP_EOL;            
            echo " debugRoutes mode said that routing was successful : ";
            echo PHP_EOL;
            echo PHP_EOL;
            echo "  - controller           :  ".$className;
            echo PHP_EOL;
            echo "  - action               :  ".$action;
            echo PHP_EOL;
            echo PHP_EOL;
            if(count($params['params'])>0){
                echo "  - params     :  ".PHP_EOL;
                foreach($params['params'] as $k=>$v){
                    echo "      - $k :    $v";
                    echo PHP_EOL;
                }
                echo PHP_EOL;
            }
            if(class_exists($className)){
                echo "  - controller exists    :  YES";
                echo PHP_EOL;

                $c=new $className();
                if(is_a($c, "\Climate\Controller")){
                    echo "  - controller is valid  :  YES";
                    echo PHP_EOL;
                }else{
                    echo "  - controller is valid  :  ".$col(" NO - It doesn't extend \Climate\Controller ")->white->bold->bg_red;
                    echo PHP_EOL;
                }


                echo "  - action is valid      : ".(method_exists($className, $action)?" YES":$c(" NO ")->white->bold->bg_red);
                echo PHP_EOL;

            }else{
                echo "  - controller is valid  :  ".$col(" NO ")->white->bold->bg_red;
                echo PHP_EOL;
            }

            echo PHP_EOL;

            // we are in debug route mode, then stop the application

            self::stop(null,"- DebugRoutes mode -");

        }
        /**=====================
         *   END DEBUG MODE    =
         ***********************/
        
        
    }
    
    
    
}