<?php

namespace Printemps;

/**
 * Description of Line
 *
 * @author soufiane
 */
class Line extends Stylized{
    
    protected $text;


    public function __construct($text) {
        parent::__construct();
        $this->text=$text;
    }
    
    public function getText() {
        return $this->text;
    }


}

?>
