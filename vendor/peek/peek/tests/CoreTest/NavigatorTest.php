<?php

use Peek\Net\Curl;
use Peek\Net\CurlParallel;

use Peek\Net\HttpQuery;

class NavigatorTest  extends PHPUnit_Framework_TestCase{
    

    
    public function testNavigatorTrait(){
        
        $test = new NavigatorClassForTraitTest();
        $this->assertEquals(["isPublic"=>null,"isProtected"=>null,"isPrivate"=>null],$test->getDefaultEntityNavigator());
        
        $test2 = new NavigatorClassForTraitTest2();
        $this->assertEquals(["isPublic"=>null,"isProtected"=>null,"isPrivate"=>null],$test2->getDefaultEntityNavigator());

    }
    
}


class NavigatorClassForTraitTest{
    public      $isPublic;
    protected   $isProtected;
    private     $isPrivate;
    
    use Peek\Entity\NavigatorTrait;
    
    
    
}
class NavigatorClassForTraitTest2{
    public      $isPublic;
    protected   $isProtected;
    private     $isPrivate;
    
    public      $isExcluded;
    
    use Peek\Entity\NavigatorTrait;
    
    public function defaultNavigatorExcludeProperty(){
        return ["isExcluded"];
    }
    
}

