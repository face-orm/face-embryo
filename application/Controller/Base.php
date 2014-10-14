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

        $manager->update(APP_VERSION, true);
        
    }
    
    public function welcome(){
        
        echo "Welcome to face embryo";
        
    }
    
    public function help(){
        
    }
                
    
}

