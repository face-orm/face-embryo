<?php

namespace Printemps;

/**
 * Description of Blok
 *
 * @author soufiane
 */
class Cloud extends Stylized{
    
    protected $width=300;
    
    protected $padding=3;
    protected $margin=3;
    
    protected $border=null;
    
    /**
     *
     * @var Line[]
     */
    protected $lines=[];
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Add a new line to the line pool
     * @param string $text content of the line
     * @return Line the newly created line
     */
    public function line($text){
        
        $this->lines[]=new Line($text);
        
        return $this->lastLine();
    }
    
    /**
     * echo the lines with style
     */
    public function flush(){
        
        foreach ($this->lines as $line){
            
            // BEGIN OF THE STYLE
            echo $line->overide($this);
            
            echo $line->getText();
            
            //END OF THE STYLE
            echo "\033[0m";
            
        }        
    }
    
    /**
     * get the last line added
     * @return Line
     */
    public function lastLine(){
        return $this->lines[count($this->lines)-1];
    }
    
}

?>
