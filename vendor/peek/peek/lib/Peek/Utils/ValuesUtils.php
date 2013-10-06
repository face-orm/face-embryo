<?php

namespace Peek\Utils;

/**
 * Description of ValuesUtils
 *
 * @author bobito
 */
class ValuesUtils {
    
    /**
     * if the given array has the given key, function will give the value at the given key, else it will return $defaultValue
     * @param type $array the array to check wether the key exists
     * @param type $key the key to check
     * @param type $defaultValue the value to return if key is not set. Default to null
     */
    public static function getIfArrayKey(&$array,$key,$defaultValue=null){
        if(isset($array[$key]))
            return $array[$key];
        else
            return $defaultValue;
    }
    
    /**
     * Look wether $n is an integer or a string representation of an integer
     * Here are some cases : 
     * 
     * $n=5     // true
     * $n=5.0   // true
     * $n="5"   // true
     * $n="5.0" // true
     * $n=-5    // true
     * $n="-5"  // true
     * $n=5.1   // false
     * $n="5.1" // false
     * 
     * @param mixed $n the value to test as an integer
     * @return boolean true if $n is an integer
     */
    public static function isInt($n){
         if(!is_numeric($n))
		return false;

	return intval($n) == $n;
    }
    
}

?>
