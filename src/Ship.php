<?php namespace Battleships;

class Ship {
    private $positions = Array();
    private $size;
    private $name;
    public function __construct($name, $size)
    {
        $this->name = $name;
        $this->size = $size;
    }

    function getSize() {
        return $this->size;
    }
    
    function setSpot($position) {
        if(count($this->positions) < $this->length) {
            $this->positions = $position;
        }
    }
}