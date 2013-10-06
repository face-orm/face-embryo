<?php

use Peek\Net\Curl;
use Peek\Net\CurlParallel;

use Peek\Net\HttpQuery;

class NetTest  extends PHPUnit_Framework_TestCase{
    
    public function testCurl(){

        /*************/
        /* test curl */

        $curl = new Curl;
        $curl->url = "http://www.google.com";
        $curl->httpheader = array('X-OOCurl-Version: ' . Curl::VERSION);

        $response = $curl->exec();
        $this->assertGreaterThan(0,strlen($response));

        
        
        /*******************/
        /* test curl mutli */

        $y = new Curl("http://www.yahoo.com/");
        $g = new Curl("http://www.google.com/");

        $m = new CurlParallel($y, $g);
        $m->exec();

        $this->assertGreaterThan(0,strlen($g->fetch()));
        $this->assertGreaterThan(0,strlen($y->fetch()));
        
        
    }
    
    public function testHttpQuery(){
        
        $query=new HttpQuery();
       // var_dump($query->setProtocol("https")->setParam("aa", "bb")->setParam("pp","mm")->execute("google.fr"));
        

        
    }
    
}