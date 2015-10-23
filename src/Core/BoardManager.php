<?php namespace Battleships\Core;

use Battleships\Ship;

class BoardManager {
    private $gridSize;
    private $ships = Array();
    private $busySpots = Array();

    function __construct($size) {
        $this->size = $size;
    }
    function addShip(Ship $ship){
        
        $this->_getAvailableSpots($ship->getSize());

    }

    public function _getAvailableSpots($shipSize) {
        $available = [
            'horizontal' => [],
            'vertical' => [],
        ];
        
        for ($i=0; $i < $this->gridSize; $i++) { 
            for ($j=0; $j < $this->gridSize; $j++) { 
                if ($this->checkSpot($i, $j)) {
                    if (($j + $shipSize) <= $this->gridSize) {
                        for ($k=$j; $k < $j + $shipSize; $k++) { 
                            if(! $this->checkSpot($i, $j)) continue 2;
                        }
                        $available['horizontal'][] = Array($i,$j);
                    }elseif (($i + $shipSize) <= $this->gridSize) {
                        for ($l=$i; $l < $i + $shipSize; $l++) { 
                            if(! $this->checkSpot($l, $j)) continue 2;
                        }
                        $available['vertical'][] = Array($i,$j);
                    }else{
                        continue;
                    }
                }else {
                    continue;
                }
            }
        }
        return $available;
    }

    private function scanHorizontalNeighbours($i, $j, $shipSize) {
        if (($j + $shipSize) <= $this->size) {
            for ($k=$j; $k < $j + $shipSize; $k++) { 
                if(! $this->checkSpot($i, $j)) return false;
            }
            return true;
        }
        return false;
    }
    private function scanVerticalNeighbours($i, $j, $shipSize) {
        $this->scanHorizontalNeighbours($j, $i, $shipSize);
    }


    private function shipFits($i, $j, $shipSize) {

    }

    private function checkSpot($i, $j)
    {
        return ! isset($this->busySpots[$i][$j]);
    }
}