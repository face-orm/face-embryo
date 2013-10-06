<?php

namespace Peek\Utils;

/**
 * Description of StringUtils
 *
 * @author Soufiane Ghzal
 */
class StringUtils {
    
    // FIRST PART OF THE CLASS IS MADE OF MODIFIER (functions which will modify a given string)
    // SECOND PART OF THE CLASS IS MAGE OF CHECKER (functions which will check if a strings matches a given pattern)

        /**
     * Will remove all extra (e.g. accents) from given string
     * @param string $haystack
     * @return string the cleaned string
     */
    public static function stripCharExtra($haystack){
            return str_replace(
                    array(
                            'à', 'â', 'ä', 'á', 'ã', 'å',
                            'î', 'ï', 'ì', 'í', 
                            'ô', 'ö', 'ò', 'ó', 'õ', 'ø', 
                            'ù', 'û', 'ü', 'ú', 
                            'é', 'è', 'ê', 'ë', 
                            'ç', 'ÿ', 'ñ',
                            'À', 'Â', 'Ä', 'Á', 'Ã', 'Å',
                            'Î', 'Ï', 'Ì', 'Í', 
                            'Ô', 'Ö', 'Ò', 'Ó', 'Õ', 'Ø', 
                            'Ù', 'Û', 'Ü', 'Ú', 
                            'É', 'È', 'Ê', 'Ë', 
                            'Ç', 'Ÿ', 'Ñ', 
                    ),
                    array(
                            'a', 'a', 'a', 'a', 'a', 'a', 
                            'i', 'i', 'i', 'i', 
                            'o', 'o', 'o', 'o', 'o', 'o', 
                            'u', 'u', 'u', 'u', 
                            'e', 'e', 'e', 'e', 
                            'c', 'y', 'n', 
                            'A', 'A', 'A', 'A', 'A', 'A', 
                            'I', 'I', 'I', 'I', 
                            'O', 'O', 'O', 'O', 'O', 'O', 
                            'U', 'U', 'U', 'U', 
                            'E', 'E', 'E', 'E', 
                            'C', 'Y', 'N', 
                    ),$haystack);
    }
    
    
    public static function subStringBefore($haystack,$needle,$n=1){
        while($n>0){
            $haystack=substr($haystack, 0, strrpos( $haystack, $needle));
            $n--;
        }
        return $haystack;
    }
    
    
    /**
     * remove all non-alphanumeric chars from the given string and return a clean string
     * @param string $haystack the string to be cleaned
     * @param boolean $removeSpaces true if spaces have to been removed too. Default to true
     * @return string the clean string
     */
    public static function onlyAlphaNum($haystack,$removeSpaces=true){
        if($removeSpaces)
            $haystack=  str_replace (" ","",$haystack);
        return preg_replace("/[^A-Za-z0-9 ]/", '', $haystack);
    }
    
    
    
    
    /**
     * Experimental Peek1 is a format for search engine where all chars are only alphanumeric and lower chars. All accents are converted before alphnum filter applies
     * @param type $newStr
     * @return type
     */
    public static function toPeek1($newStr){ 
        $newStr = StringUtils::stripCharExtra($newStr);
        $newStr = strtolower($newStr);
        $newStr = StringUtils::onlyAlphaNum($newStr);
        
        return $newStr;
    }
    
    /**
     * BPeek1 is made of multiple Peek1 , each surrounded by a dot [.]. Dot are converted from 
     *  - comma [,]
     *  - dot [.]
     *  - colon [:]
     *  - semicolon [;]
     *  - pipe [|]
     * note that spaces [ ] dashes [-] and underscore [_] are ignored and will be converted to Peek1
     * 
     * This format allows a strict sql search in a keyword list
     * 
     * e.g. : 
     *      you have this BPeek1 keyword list :   .music.cd.acdc.
     *      you want to find "cd"
     *      you will do :  
     *          my_column LIKE "%.cd.%"
     *      Then you wont match with "acdc"
     * @deprecated 
     * @param type $newStr
     * @return type
     */
    private static function toBPeek1($newStr){ 
        
        // TODO : think more about this format
        
        return $newStr;
    }
    
    
    
    
    
    
    
    // HERE BEGINS THE SECOND PART
    
    /**
     * look if $subject begins with $search
     * @param string $search the string that we want to find in $subject
     * @param string $subject the string in which we search
     * @return boolean true if $subject beguins with $search
     */
    public static function beginsWith($search,$subject){
        return 0 === strncmp($subject,$search,  strlen($search)) ;
    }
    
    // TODO ends with
    
    /**
     * test if the given string is a valid md5
     * @param string $str string to test
     * @return boolean true if the given str is md5 formated
     */
    public function isMd5($str){
        // sha1 string is made of 32 alnum chars
        return 32 === strlen($str) && ctype_alnum($str);
    }
    
    /**
     * test if the given string is a valid sha1
     * @param string $str string to test
     * @return boolean true if the given str is sha1 formated
     */
    public function isSha1($str){
        // sha1 string is made of 40 hexadecimals chars
        return 40 === strlen($str) && ctype_xdigit($str);
    }
    
    public function isMongoId($str){
        // Mongo id is made of 24 hexadecimals chars
        return 24 === strlen($str) && ctype_xdigit($str);
    }
    
    
}

?>
