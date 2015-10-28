<?php namespace Battleships\Core\Renderers;

use Battleships\Core\Board;

interface BoardRendererInterface
{
    public function renderGrid(Board $board, $cheatMode);
}
