<?php namespace Battleships\Controllers;

use Battleships\Core\BoardManager;

class WebController extends GameController {
    private $userInput;

    public function start()
    {   
        /*$this->userInput =  isset($_POST['coords']) ? $_POST['coords'] : '';
        $this->handleInput();*/

        $board = new BoardManager(10);
        print_r($board->_getAvailableSpots(4));
        /*$data['grid'] = $this->board->printBoard();
        $view = new WebView($data); 
        $view->render();*/
    }
}