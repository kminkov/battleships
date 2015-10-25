<?php namespace Battleships\Core;

class Point {
	
	private $row;
	private $column;

	function __construct($row, $column) {
		$this->row = $row;
		$this->column = $column;
	}

	public function getRow()
	{
		return $this->row;
	}

	public function getColumn()
	{
		return $this->column;
	}
}