<?php

namespace Controller;

use Herrera\Phar\Update\Manager;
use Herrera\Phar\Update\Manifest;

/**
 * Description of Default
 *
 * @author bobito
 */
class Base extends \Climate\Controller{

    public function update(){
              
    
        $manifest = 'http://laemons.github.io/face-embryo/manifest.json';
        
        $manager = new Manager(Manifest::loadFile($manifest));

        $updated = $manager->update(APP_VERSION, true, true);
        
        if($updated){
            echo \Printemps::Color("Embryo was updated", "green");
        }else{
            echo \Printemps::Color("No Update available", "yellow");
        }
        
    }
    
    public function welcome(){
        
        echo "Face embryo";
        echo PHP_EOL;
        echo " Version : " . APP_VERSION;
        
        echo PHP_EOL;
        echo PHP_EOL;
        
        echo "For help : embryo help";
    }
    
    public function help(){
        
    }
                
    
}

