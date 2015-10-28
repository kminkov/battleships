<?php namespace Battleships\Views;

class ConsoleView implements ViewInterface
{
    private $data = array();

    public function __construct($data = array())
    {
        $this->data = $data;
    }

    public function render($data = array())
    {
        echo (isset($data['shotResult'])) ? $data['shotResult'] : '';
        echo "\n";
        echo (isset($data['grid'])) ? $data['grid'] : '';
        echo "\n";
        if ($data['gameOver']) {
            echo "Well done! You completed the game in {$data['shotsToSuccess']} shots.";
        } else {
            echo "Enter coordinates (row, col), e.g. A5 = ";
        }
    }
}
