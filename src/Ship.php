<?php namespace Battleships;



use Battleships\Core\Point;



class Ship {

    private $positions = Array();
    private $size;
    private $name;
    private $shots = 0;

    public function __construct($name, $size)
    {
        $this->name = $name;
        $this->size = $size;
    }

    public function getSize() 
    {
        return $this->size;
    }
    
    public function setPoint(Point $point) 
    {
        if(count($this->positions) < $this->size) {
            $this->positions[] = $point;
        }
    }

    public function checkPoint(Point $point) 
    {
        return array_search($point, $this->positions) !== false;
    }

    public function hit(Point $point) 
    {
        $this->shots += 1;
    }
    
    public function isSunk()
    {       
        return $this->shots == $this->size;
    }
}