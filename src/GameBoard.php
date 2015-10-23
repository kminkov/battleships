<?php namespace Battleships;

class GameBoard
{
    private $board = array();
    private $gridSize;
    private $letterMap = array();

    public function __construct($gridSize=10)
    {
       $this->gridSize = $gridSize;
       $this->letterMap = range('A','Z');
    }

    private function initializeBoard()
    {   
        $this->board['0'] = range('1',$this->gridSize);
        array_unshift($this->board['0'], ' ');

        for ($i=1; $i<=$this->gridSize; $i++) {
            for ($j=0; $j<=$this->gridSize; $j++) {
                if ($j==0) {
                    $this->board[$i][$j] = $this->letterMap[$i];
                }else{
                    $this->board[$i][$j] = ".";
                }
            }
        }
    }

    public function printBoard()
    {   
        $boardOutput = '';
        $this->initializeBoard();

        foreach ($this->board as $columns => $line) {
            foreach ($line as $key => $item) {
                $boardOutput .= " $item ";
            }
            $boardOutput .= "\n";
        }
        return $boardOutput;
       /* for ($i=0; $i<$this->gridSize; $i++) {
            if ($i==0) {
                 echo "   ";
                foreach (range(1, $this->gridSize) as $number) {
                    echo " $number ";
                }
                echo "\n";
            }
            for ($j=0; $j<$this->gridSize; $j++) {
                if ($j==0) {
                    echo " {$this->letterMap[$i]} ";
                }
                echo " . "; 

            }
            echo "\n\n";
        }
        echo "</pre>";*/
    }
}
