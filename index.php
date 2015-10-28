<?php 
require __DIR__ . '/vendor/autoload.php';

use Battleships\Controllers\ConsoleController;
use Battleships\Controllers\WebController;

session_start();
$gridSize = 10;
if (php_sapi_name() == 'cli') {
    $game = new ConsoleController($gridSize);
}else {
    $game = new WebController($gridSize);
} 

$game->start();