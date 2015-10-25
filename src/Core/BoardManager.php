<?php namespace Battleships\Core;

use Battleships\Ship;
use Battleships\Core\Point;

class BoardManager
{
    private $gridSize;
    public $ships = array();
    private $busySpots = array();

    public function __construct($gridSize)
    {
        $this->gridSize = $gridSize;
    }

    /**
     * Add ship to the board.
     * @param Ship $ship
     */
    public function addShip(Ship $ship)
    {
        $availablePositions = $this->getAvailableSpots($ship->getSize());
        
        $direction = array_rand($availablePositions);

        $startPointIndex = array_rand($availablePositions[$direction]);
        $startPoint = $availablePositions[$direction][$startPointIndex];

        $this->placeShip($ship, $startPoint, $direction);
    }
    /**
     * Scan the board for available starting positions for ship.
     * @param  int $shipSize
     * @return Array 
     */
    public function getAvailableSpots($shipSize)
    {
        $available = [
            'horizontal' => [],
            'vertical' => [],
        ];

        for ($i=0; $i < $this->gridSize; $i++) {
            for ($j=0; $j < $this->gridSize; $j++) {
                if ($this->checkSpot($i, $j)) {
                    if ($this->shipFitsHorizontally($i, $j, $shipSize)) {
                        $available['horizontal'][] = new Point($i, $j);
                    }
                    if ($this->shipFitsVertically($i, $j, $shipSize)) {
                        $available['vertical'][] = new Point($i, $j);
                    }
                } else {
                    continue;
                }
            }
        }
        return $available;
    }

    private function shipFitsHorizontally($i, $j, $shipSize)
    {
        if (($j + $shipSize) <= $this->gridSize) {
            for ($k=$j; $k < $j + $shipSize; $k++) {
                if (! $this->checkSpot($i, $j)) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    private function shipFitsVertically($i, $j, $shipSize)
    {
        if (($i + $shipSize) <= $this->gridSize) {
            for ($k=$i; $k < $i + $shipSize; $k++) {
                if (! $this->checkSpot($i, $j)) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Helper function placing the ship on the board.
     * @param  Ship   $ship     
     * @param  Point  $startPoint
     * @param  String $direction 
     */
    private function placeShip(Ship $ship, Point $startPoint, $direction)
    {
        if ($direction == 'horizontal') {
            $end = $startPoint->getColumn() + $ship->getSize() - 1;
            $row = $startPoint->getRow();
            foreach (range($startPoint->getColumn(), $end) as $column) {
                $ship->setPoint(new Point($row, $column));
                $this->busySpots[$row][$column] = true;
            }

        } else {
            $end = $startPoint->getRow() + $ship->getSize() - 1;
            $column = $startPoint->getColumn();
            foreach (range($startPoint->getRow(), $end) as $row) {
                $ship->setPoint(new Point($row, $column));
                $this->busySpots[$row][$column] = true;
            }
        }
        $this->ships[] = $ship;
    }

    private function checkSpot($i, $j)
    {
        return ! isset($this->busySpots[$i][$j]);
    }

    public function getSize()
    {
        return $this->gridSize;
    }
}
