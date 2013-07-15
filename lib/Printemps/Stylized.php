<?php

namespace Printemps;

/**
 * Description of Stylized
 *
 * @author soufiane
 */
class Stylized extends \ArrayObject{
    
    const STYLE_BG="background";
    const STYLE_COLOR="color";
    const STYLE_BOLD="bold";
    const STYLE_UNDERLINE="underline";
    
    public function __construct() {

    }
    
    /**
     * take the given style and overide its properies with these of this style
     * @param \Printemps\Stylized $style
     * @return \Printemps\Stylized
     */
    public function overide(Stylized $style){
        $newStyle = new Stylized();

        foreach($style as $k=>$v){
            $newStyle[$k]=$v;
        }
        
        foreach($this as $k=>$v){
            $newStyle[$k]=$v;
        }
        
        return $newStyle;
        
    }
    
    
    public function shellize(){
        
        $shellString="\033[";
        
        $i=0;
        foreach($this as $v){
            
            if($i>0)
                $shellString.=";";
            else
                $i++;
            
            $shellString.=$v;
            
            
        }
        
        $shellString.="m";
        
        return $shellString;
        
    }
    
    
    public function __toString() {
        return $this->shellize();
    }

}

?>
