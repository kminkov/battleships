<?php namespace Battleships\Views;

class WebView implements ViewInterface {

    const TEMPLATE = 'src/Templates/battleships.html';
    private $data = Array();

    function __construct($data = Array()) {
        $this->data = $data;

    }

    function render($data = Array()) {
        if (! empty($data)) {
            $this->data = $data;
        }

        extract($this->data);

        ob_start();
        include( self::TEMPLATE);
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;

    }

}



