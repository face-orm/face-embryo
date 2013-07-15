<?php

class Printemps{
    
    
    private static $colors=array(
        "balck"  => "30",
        "red"    => "31",
        "green"  => "32",
        "yellow" => "33",
        "blue"   => "34",
        "purple" => "35",
        "lblue"  => "36",
        "gray"   => "37",
    );
    
    public static function Color($str,$color,$bg=0){
        $code=self::$colors[$color];
        return ($bg>0?"\033[$bg"."m":"")."\033[".$code."m $str \033[0m";
    }
    
    
}