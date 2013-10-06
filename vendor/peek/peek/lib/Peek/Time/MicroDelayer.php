<?php

namespace Peek\Time;

/**
 * 
 * When @see Delayer will wait for seconds, MicroDelayer will wait for Microseconds
 * 
 * @author sghzal
 * 
 */
class MicroDelayer extends Delayer {
    
    protected function _wait($time) {
        usleep($time);
    }

    
}