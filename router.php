<?php

use Shappy\Http\Router;

$router = new Router;

$router->addRoute('GET', '/', 'homeController@index');
$router->addRoute('GET', '/user', 'homeController@data');