<?php namespace Battleships;

use Battleships\GameBoard;
use Battleships\Ship;


class GameManager {
    
    private $ships = Array();
    private $board;

    function __construct(GameBoard $board, Array $ships) {
        $this->ships = $ships;
    }
    
}