<?php namespace Battleships\Controllers;

use Battleships\GameBoard;
use Battleships\Views\WebView;

class GameController 
{
    private $board;
    private $userInput;
    
    function __construct() {
        $this->board = new GameBoard(10);
    }

    function handleInput() {
        
    }
}