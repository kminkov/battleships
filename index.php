<?php 

require __DIR__ . '/vendor/autoload.php';

use Battleships\Controllers\GameController;
use Battleships\Controllers\WebController;

session_start();
if (php_sapi_name() == 'cli') {
    $app = new ConsoleApplication($container);
}else {
    $game = new WebController();
}
$game->start();