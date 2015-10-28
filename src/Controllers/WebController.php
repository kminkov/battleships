<?php namespace Battleships\Controllers;

use Battleships\Controllers\ControllerInterface;
use Battleships\Core\Game;
use Battleships\Core\Renderers\SimpleBoardRenderer;
use Battleships\Views\WebView;

class WebController implements ControllerInterface
{
    function __construct($gridSize) {
        $this->game = new Game($gridSize, new SimpleBoardRenderer);
        $this->view = new WebView();
    }

    public function start()
    {   
        $this->game->setUserInput($this->getUserInput()); 
        $this->game->play();
        $this->view->render($this->game->getOutputData());
    } 

    public function getUserInput()
    {
        return isset($_POST['coord']) ? $_POST['coord'] : '';
    } 

}