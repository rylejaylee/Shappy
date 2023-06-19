<?php

namespace Shappy\Http;

use Shappy\Controllers\HomeController;
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
        if(HOME_URL == '/') {
            header("Location: $location");
            exit;
        }
        $home_url = HOME_URL;
        header("Location: $home_url$location");
        exit;
    }

    protected function back()
    {
        header("Location: {$_SERVER['REQUEST_URI']}");
        exit;
    }
}
