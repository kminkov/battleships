<?php namespace Battleships\Controllers;



use Battleships\Core\BoardManager;

use Battleships\Ship;

use Battleships\Views\WebView;



class WebController extends GameController {

    protected $userInput;

    function __construct() {
        parent::__construct();
        $this->view = new WebView();
    }

    public function start()
    {   
        
        /*
        $this->handleInput();*/
        $this->userInput = $this->getUserInput();
        $this->play();
        $data['grid'] = $this->drawBoard();
        $data['user_output'] = $this->getUserOutput();
        $this->view->render($data);

       // print_r($board->_getAvailableSpots(4));

        /*$data['grid'] = $this->board->printBoard();

        $view = new WebView($data); 

        $view->render();*/

    }

    public function getUserInput()
    {
        return isset($_POST['coord']) ? $_POST['coord'] : '';
    } 

}