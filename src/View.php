<?php namespace Battleships;

/**
 * View-specific wrapper.
 * Limits the accessible scope available to templates.
 */
class View{
    /**
     * Template being rendered.
     */
    protected $template = null;

    const TEMPLATE_DIR = 

    /**
     * Initialize a new view context.
     */
    public function __construct($template) {
        $this->template = $template;
    }

    /**
     * Render the template, returning it's content.
     * @param array $data Data made available to the view.
     * @return string The rendered template.
     */
    public function render(Array $data) {
        extract($data);

        ob_start();
        include( APP_PATH . DIRECTORY_SEPARATOR . $this->template);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}

?>