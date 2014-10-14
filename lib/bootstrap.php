<?php 

/**
 * @license See LICENSE
 */

/*
                                _
                               (  )
                            ( `  ) . )
                          (_, _(  ,_)_)

      ___           ___                   ___           ___           ___     
     /\  \         /\__\      ___        /\__\         /\  \         /\  \    
    /::\  \       /:/  /     /\  \      /::|  |       /::\  \        \:\  \   
   /:/\:\  \     /:/  /      \:\  \    /:|:|  |      /:/\:\  \        \:\  \  
  /:/  \:\  \   /:/  /       /::\__\  /:/|:|__|__   /::\~\:\  \       /::\  \ 
 /:/__/ \:\__\ /:/__/     __/:/\/__/ /:/ |::::\__\ /:/\:\ \:\__\     /:/\:\__\
 \:\  \  \/__/ \:\  \    /\/:/  /    \/__/~~/:/  / \/__\:\/:/  /    /:/  \/__/
  \:\  \        \:\  \   \::/__/           /:/  /       \::/  /    /:/  /     
   \:\  \        \:\  \   \:\__\          /:/  /        /:/  /     \/__/      
    \:\__\        \:\__\   \/__/         /:/  /        /:/  /                 
     \/__/         \/__/                 \/__/         \/__/                
                                                    
                                     
                                        _ . 
                                      (  _ )_                     
                                    (_  _(_ ,)
                                                             |
               _  _                                        \ _ /
              ( `   )_                                   -= (_) =-
             (    )    `)                                  /   \
           (_   (_ .  _) _)                                  |


*/


/**
 * Define Begin time of Script for Stats
 */
define("START_SCRIPT", microtime(true));

define("APP_ROOT",__DIR__ . "/..");

/**
 * Get Composer Autoloader because it just works like a charm :)
 */
require_once APP_ROOT . "/vendor/autoload.php";

/**
 * SET THE BASE DIRECTORY
 */

\Climate\Application::$baseDir = realpath( getcwd() );


/*===============================
 *                              =
 *     Prepares the Configs     =
 *                              =
 ********************************/

$configsFile = APP_ROOT . "/application/climate.config.yml";
$configArray = (new Symfony\Component\Yaml\Parser())->parse(file_get_contents($configsFile));

Climate\Config::build($configArray);




/*===============================
 *                              =
 * Get and Parse the yaml route =
 *                              =
 ********************************/
$routeFile=  APP_ROOT . "/application/routes.yml";

$routeArray=(new Symfony\Component\Yaml\Parser())->parse(file_get_contents($routeFile));

$router=new \Climate\Router($routeArray);


/*==============================
 *                             =
 * Let's Start the Application =
 *                             =
 *******************************/

Climate\Application::init(array_slice($argv,1),$router);

require APP_ROOT . '/application/onStartup.php';

Climate\Application::start();