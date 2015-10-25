<?php namespace Battleships\Controllers;

use Battleships\Core\BoardManager;
use Battleships\Core\Point;
use Battleships\Ship;
use Battleships\Views\WebView;

class GameController 
{   
    const GRID_SIZE = 10;
    private $board;
    protected $userInput;
    private $letterMap = array();
    private $shots = array();
    private $userOutput;

    function __construct() {
        $this->letterMap = range('A','Z');
    }

    private function initGame() {
        $this->board = new BoardManager(self::GRID_SIZE);

        $this->board->addShip(new Ship('Destroyer',4));
        $this->board->addShip(new Ship('Destroyer',4));
        $this->board->addShip(new Ship('Battleship',5));

        $this->shots = array('hit' => array(), 'miss' => array());
        
    }

    public function drawBoard()
    {   
        $boardOutput = '    ' . implode('  ', range(1, $this->board->getSize())) . "\n";

        for ($i=0; $i<$this->board->getSize(); $i++) {
            for ($j=0; $j<$this->board->getSize(); $j++) {
                if ($j==0) {
                    $boardOutput .= " {$this->letterMap[$i]} ";
                } 
                $boardOutput .= $this->drawSpot(new Point($i, $j));
            }
            $boardOutput .= "\n";
        }
        return $boardOutput;
    }

    public function drawSpot($point)
    {
        if(in_array($point, $this->shots['hit'])) {
            return " X ";
        } 
        if(in_array($point, $this->shots['miss'])) {
            return " - ";
        }

        return " . ";
    }

    public function play()
    {   
        if (isset($_SESSION['board'])) {
            $this->board = $_SESSION['board'];
            $this->shots = $_SESSION['shots'];
            if(! empty($this->userInput)) {
                $this->makeShot();
            }

        } else {
            $this->initGame();
        }
        $_SESSION['board'] = $this->board;
        $_SESSION['shots'] = $this->shots;
    }

    private function makeShot()
    {
        $shotPoint = $this->processUserInput();
        
        $hit = false;
        foreach ($this->board->ships as $ship) {
            if ($ship->checkPoint($shotPoint)) {
                $hit = true;
                if (! in_array($shotPoint, $this->shots['hit'])) {
                    $ship->hit($shotPoint);
                    $this->userOutput = "HIT";
                }
                if ($ship->isSunk()) {
                    $this->userOutput = "SUNK";
                }

                break;
            } 
        }

        if($hit) {
            $this->shots['hit'][] = $shotPoint;
        } else {
            $this->shots['miss'][] = $shotPoint;
            $this->userOutput = "MISS";
        }

    }

    private function processUserInput() 
    {
        if (preg_match("/[A-Z][0-9]+/", $this->userInput)===1) {

            preg_match("/[A-Z]/", $this->userInput, $row);
            preg_match("/[0-9]+/", $this->userInput, $column);
            $row = array_search($row['0'], $this->letterMap); 
            $column = $column['0'] - 1;
            
            if ($row > self::GRID_SIZE || $column > self::GRID_SIZE) {
                throw new WrongInputException();
            }
            return new Point($row, $column);
        } else {
            throw new WrongInputException();
        }
    }

    public function getUserOutput()
    {
        return $this->userOutput;
    }
}