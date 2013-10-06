<?php

/* this class is being developed */

namespace Peek\Net;

use Peek\Utils\StringUtils;

/**
 * Description of HttpQuery
 *
 * @author sghzal
 */
class HttpQuery {
    
    const METHOD_GET="get";
    
    protected $params=[];
    
    protected $method=self::METHOD_GET;
    
    protected $protocol="http";


    public function __construct() {
        
    }
    
    public function setMethod($method) {
        $this->method = $method;
        return $this;
    }

    /**
     * add a param for the query. If params already exists then it is overwritten
     * @param string $name name of the param
     * @param string $value value of the param
     * @return HttpQuery this instance
     */
    public function setParam($name,$value){
        $this->params[$name]=$value;
        return $this;
    }
    
    /**
     * Get the value of the given param
     * @param string $name name of the param we want to get
     * @return string value of the param
     */
    public function param($name){
        return $this->params[$name];
    }
    
    /**
     * add all given param to the actual param list. Is one already exists, it is overwritten
     * @param array $params list of params name=>value
     * @return HttpQuery this instance
     */
    public function setParams($params){
        foreach($params as $name=>$value)
            $this->params[$name]=$value;
        
        return $this;
    }
    
    /**
     * flush all the params
     */
    public function flushParams(){
        $this->params=[];
    }
    

    public function doGetUrl($url){

        $url=$this->protocol."://".$url;
        
        $paramStr="";
        
        if(count($this->params)>0){
            $paramStr.="?".http_build_query ($this->params);
        
            // if given url already contains some params, then remove the "?" at the begin of the new params and replace it by a &
            if(strpos($url,"?") !== false)
                $paramStr = "&" . ltrim($paramStr,"?");
        }
        
        return $url.$paramStr;
    }
    
    /**
     * executes the query and returns the reponse
     * @param string $nudeUrl the url without protocol or param. If you want http://google.com just specify "google.com"  protocol is set thanks to "setProtocol"
     * @throws Exception
     */
    public function execute($nudeUrl){
        
        if(self::METHOD_GET === $this->method){
            $newUrl=$this->doGetUrl($nudeUrl);
            
            $c = new Curl();
            $c->url=$newUrl;
            $c->followLocation();
            $r=$c->exec();
            
            return $r;
        }
        
        throw new \Exception("Invalide method name : '".$this->method."'");
    }
    
    public function setProtocol($protocol) {
        $this->protocol = $protocol;
        return $this;
    }


    
}
