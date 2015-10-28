<?php namespace Battleships\Views;

class WebView implements ViewInterface
{
    const TEMPLATE = 'src/Templates/battleships.html';
    private $data = array();

    public function __construct($data = array())
    {
        $this->data = $data;
    }

    public function render($data = array())
    {
        if (! empty($data)) {
            $this->data = $data;
        }

        extract($this->data);

        ob_start();
        include(self::TEMPLATE);
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }
}
