<?php 


namespace Shappy\Http;

class View
{
    protected $viewPath;
    protected $data;

    public function __construct($viewPath, $data = [])
    {
        $this->viewPath = $viewPath;
        $this->data = $data;
    }

    public function render()
    {
        extract($this->data);
        ob_start();
        require "./views/".$this->viewPath.".php";
        $content = ob_get_clean();

        unset($_SESSION['_old_input']);
    
        return $content;
    }
}