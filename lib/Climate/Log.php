<?php

/**
 * @license See LICENSE
 */

namespace Climate;

use Monolog\Logger;


/**
 * Description of Logger
 *
 * @author Soufiane GHZAL
 */
class Log {
    
    /**
     *
     * @var Logger[]
     */
    protected static $loggers=[];
    
    public static function add($name,Logger $logger){
    
        self::$loggers[$name]=$logger;
        
    }
    
    public static function __callStatic($name, $arguments) {
        if(!isset(self::$loggers[$name]))
            throw new Exception("Logger $name doesn't exist");
        
        self::$loggers[$name]->log(100,$arguments[0]);
    }
    
    /**
     * Translate the given errno to the matching constant name
     * @param string $errno
     * @return string
     */
    public static function errnoToString($errno){
        
        //from : http://frankkoehl.com/2009/05/translating-php-error-constants/
        
        switch ($errno) {
            case 1:     $e_type = 'E_ERROR'; break;
            case 2:     $e_type = 'E_WARNING'; break;
            case 4:     $e_type = 'E_PARSE'; break;
            case 8:     $e_type = 'E_NOTICE'; break;
            case 16:    $e_type = 'E_CORE_ERROR'; break;
            case 32:    $e_type = 'E_CORE_WARNING'; break;
            case 64:    $e_type = 'E_COMPILE_ERROR'; break;
            case 128:   $e_type = 'E_COMPILE_WARNING'; break;
            case 256:   $e_type = 'E_USER_ERROR'; break;
            case 512:   $e_type = 'E_USER_WARNING'; break;
            case 1024:  $e_type = 'E_USER_NOTICE'; break;
            case 2048:  $e_type = 'E_STRICT'; break;
            case 4096:  $e_type = 'E_RECOVERABLE_ERROR'; break;
            case 8192:  $e_type = 'E_DEPRECATED'; break;
            case 16384: $e_type = 'E_USER_DEPRECATED'; break;
            case 30719: $e_type = 'E_ALL'; break;
            default:    $e_type = 'E_UNKNOWN'; break;
          }
    
          return $e_type;
    }
    
    
    public static function errnoIsCritical($errno){
        $isCritical = false;
        
        switch ($errno) {
          case 1:     $isCritical = true; break;
          case 16:    $isCritical = true; break;
          case 64:    $isCritical = true; break;
          case 256:   $isCritical = true; break;
          case 4096:  $isCritical = true; break;
          case 30719: $isCritical = true; break;
        }
        
        return $isCritical;
    }
    
}

?>
