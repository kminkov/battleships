<?php namespace Battleships\Core;

use Battleships\Core\Ship;
use Battleships\Core\Point;

class Board
{
    private $gridSize;
    private $ships = array();
    private $busySpots = array();

    public  $shots;

    public function __construct($gridSize)
    {
        $this->gridSize = $gridSize;
        $this->shots = array('hit' => array(), 'miss' => array(), 'counter'=>0);
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
                $current_point = new Point($i, $j);
                if ($this->freeSpot($current_point)) {
                    if ($this->shipFitsHorizontally($current_point, $shipSize)) {
                        $available['horizontal'][] = $current_point;
                    }
                    if ($this->shipFitsVertically($current_point, $shipSize)) {
                        $available['vertical'][] = $current_point;
                    }
                } else {
                    continue;
                }
            }
        }
        return $available;
    }

    /**
     * Checks if ship can be placed horizontally.
     * @param  Point  $point    Starting point for the ship
     * @param  int    $shipSize The size of the ship
     * @return bool
     */
    private function shipFitsHorizontally(Point $point, $shipSize)
    {
        if (($point->getColumn() + $shipSize) <= $this->gridSize) {
            for ($k=$point->getColumn(); $k < $point->getColumn() + $shipSize; $k++) {
                if (! $this->freeSpot(new Point($point->getRow(), $k))) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Checks if ship can be placed vertically.
     * @param  Point  $point Starting point for the ship
     * @param  int $shipSize The size of the ship
     * @return bool
     */
    private function shipFitsVertically(Point $point, $shipSize)
    {
        if (($point->getRow() + $shipSize) <= $this->gridSize) {
            for ($k=$point->getRow(); $k < $point->getRow() + $shipSize; $k++) {
                if (! $this->freeSpot(new Point($k, $point->getColumn()))) {
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
                $point = new Point($row, $column);
                $ship->setPoint($point);
                $this->busySpots[] = $point;
            }

        } else {
            $end = $startPoint->getRow() + $ship->getSize() - 1;
            $column = $startPoint->getColumn();
            foreach (range($startPoint->getRow(), $end) as $row) {
                $point = new Point($row, $column);
                $ship->setPoint($point);
                $this->busySpots[] = $point;
            }
        }
        $this->ships[] = $ship;
    }

    /**
     * Check if all ships on board are sunk.
     * @return bool
     */
    public function allShipsSunk()
    {
        foreach ($this->ships as $ship) {
            if (! $ship->isSunk()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Checks if the provided position is taken by a ship.
     * @param  Point  $point
     * @return bool
     */
    public function freeSpot(Point $point)
    {
        return ! in_array($point, $this->busySpots);
    }

    public function getSize()
    {
        return $this->gridSize;
    }

    public function getShips()
    {
        return $this->ships;
    }
}
