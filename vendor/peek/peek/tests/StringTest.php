<?php


class StringTest  extends PHPUnit_Framework_TestCase{
    
    
    public function testSubStr(){
        
        $a="i'm the world";
        $b="this world is idiot";
        $c="that's idiot, isnt it ?..";
        
        $this->assertEquals("i" , Peek\Utils\StringUtils::subStringBefore($a, "'", 1));
        $this->assertEquals($a  , Peek\Utils\StringUtils::subStringBefore($a, "'", 0));
        $this->assertEquals("this world" , Peek\Utils\StringUtils::subStringBefore($b, " ", 2));
        $this->assertEquals("that's idiot, isnt it ?" , Peek\Utils\StringUtils::subStringBefore($c, ".", 2));
        $this->assertEquals("that's idiot, ", Peek\Utils\StringUtils::subStringBefore($c, "isnt", 1));
        
    }
    
}
