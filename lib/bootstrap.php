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

/**
 * Set Basepath to Root of Application. It makes includes easier .
 */
$baseDir = realpath( getcwd() );
chdir(__DIR__."/../");


/**
 * Get Composer Autoloader because it just works like a charm :)
 */
require_once "vendor/autoload.php";

/**
 * SET THE BASE DIRECTORY
 */

\Climate\Application::$baseDir=$baseDir;


/*===============================
 *                              =
 *     Prepares the Configs     =
 *                              =
 ********************************/

$configsFile = "application/climate.config.yml";
$configArray = (new Symfony\Component\Yaml\Parser())->parse(file_get_contents($configsFile));

Climate\Config::build($configArray);





/*===============================
 *                              =
 *       Prepare loggers        =
 *                              =
 ********************************/

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\NativeMailerHandler;

// =============
// Error Log
$logE = new Logger('error');

//Log file
$logE->pushHandler(new StreamHandler(Climate\Config::errorLog()));

//Email
if("yes" === Climate\Config::sendEmailOnError() && Climate\Config::sendEmailOnErrorTo()) // if config said to send a mail when an error happens
    $logE->pushHandler(new NativeMailerHandler(Climate\Config::sendEmailOnErrorTo(),"Climate got an error during execution","Climate App"));
//Add to the available logs
Climate\Log::add('error', $logE);


// =============
// Access Log
$logA = new Logger('access');
$logA->pushHandler(new StreamHandler(Climate\Config::accessLog()));
Climate\Log::add('access', $logA);



/*===============================
 *                              =
 *   Set Handlers for Errors    =
 *                              =
 ********************************/

// Exceptions 
set_exception_handler(function(Exception $e){
    Climate\Log::error("Uncaught exception has stopped the script with the message '"
            .$e->getMessage()."' in the file "
            .$e->getFile().":"
            .$e->getLine());
    
    Climate\Application::stopOnError();
    
});

register_shutdown_function(function(){
    
    # Getting last error
    $error = error_get_last();
    
    if(in_array($error['type'], [ E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING ])){
        
        Climate\Log::error(\Climate\Log::errnoToString($error['type'])." - Error has stopped the script with the message '"
            .$error['message']."' in the file "
            .$error['file'].":"
            .$error['line']
        );
        
        echo "Script has ended after a critical Error, see logs for furthers informations.".PHP_EOL;
    }

    
});

//Errors
set_error_handler(function($errno, $errstr, $errfile, $errline){
    
    $critical=  \Climate\Log::errnoIsCritical($errno);
    
    Climate\Log::error(\Climate\Log::errnoToString($errno)." - Error ".($critical?"has stopped the script":"happened")." with the message '"
            .$errstr."' in the file "
            .$errfile.":"
            .$errline
        );
    
    if($critical)
        Climate\Application::stopOnError();
    else
        return true;
});





/*===============================
 *                              =
 * Get and Parse the yaml route =
 *                              =
 ********************************/
$routeFile=Climate\Config::routesFile();

$routeArray=(new Symfony\Component\Yaml\Parser())->parse(file_get_contents($routeFile));

$router=new \Climate\Router($routeArray);


/*==============================
 *                             =
 * Let's Start the Application =
 *                             =
 *******************************/

Climate\Application::init(array_slice($argv,1),$router);

require 'application/onStartup.php';

Climate\Application::start();