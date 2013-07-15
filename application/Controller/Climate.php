<?php

namespace Controller;

/**
 * Description of Default
 *
 * @author bobito
 */
class Climate extends \Climate\Controller{

    public function climate(){
        echo "
            

================================================================================            
                                                             |
               _  _                                        \ _ /
              ( `   )_                                   -= (_) =-
             (    )    `)                                  /   \
           (_   (_ .  _) _)                                  |
      ___           ___                   ___           ___           ___     
     /\  \         /\__\      ___        /\__\         /\  \         /\  \    
    /::\  \       /:/  /     /\  \      /::|  |       /::\  \        \:\  \   
   /:/\:\  \     /:/  /      \:\  \    /:|:|  |      /:/\:\  \        \:\  \  
  /:/  \:\  \   /:/  /       /::\__\  /:/|:|__|__   /::\~\:\  \       /::\  \ 
 /:/__/ \:\__\ /:/__/     __/:/\/__/ /:/ |::::\__\ /:/\:\ \:\__\     /:/\:\__\
 \:\  \  \/__/ \:\  \    /\/:/  /    \/__/~~/:/  / \/__\:\/:/  /    /:/  \/__/
  \:\  \        \:\  \   \::/__/           /:/  /       \::/  /    /:/  /     
   \:\  \        \:\  \   \:\__\          /:/  /        /:/  /     \/__/      
    \:\__\        \:\__\   \/__/         /:/  /        /:/  /                 
     \/__/         \/__/                 \/__/         \/__/               

================================================================================
                                     =
                                   =====
                                ============
                                
               CLIMATE DEFAULT CONTROLLER WORKS LIKE A CHARM :)
               
       YOU CAN SEE THE DOC AT : https://github.com/SneakyBobito/climate
    
                                ============
                                   =====
                                     =
";
        
                                                    
    
        
        
        
    }
    
    public function word(){
        
        if($this->n<=0){
            throw new \Exception("n must be positive");
        }
        
        for($i=0;$i<$this->n;$i++){
            echo $this->w;
            echo PHP_EOL;
        }
        
        
    }
                
    
}
?>
