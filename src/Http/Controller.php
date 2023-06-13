<?php

namespace Shappy\Http;

use Shappy\Utils\FlashMessage;

class Controller
{
    protected function view($path, $data = [])
    {
        $view = new View($path, $data);
        return $view->render();
    }

    protected function flash($key, $message) 
    {
        FlashMessage::set($key, $message);
    }

    protected function redirect($location)
    {
        header("Location: $location");
        exit;
    }

    protected function back()
    {
        header("Location: {$_SERVER['REQUEST_URI']}");
        exit;
    }
}
