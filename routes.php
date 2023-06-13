<?php

use Shappy\Http\Router;

$router = new Router;

$router->addRoute('GET', '/', 'HomeController@index');
// Auth routes
$router->addRoute('GET', '/auth/login', 'AuthController@login_view');
$router->addRoute('POST', '/auth/login', 'AuthController@login');
$router->addRoute('GET', '/auth/register', 'AuthController@register_view');
$router->addRoute('POST', '/auth/register', 'AuthController@register');
$router->addRoute('GET', '/auth/logout', 'AuthController@logout');
// novels routes
$router->addRoute('GET', '/novel/create', 'NovelsController@create');
$router->addRoute('POST', '/novel/store', 'NovelsController@store');
$router->addRoute('GET', '/novel/edit', 'NovelsController@edit');
$router->addRoute('POST', '/novel/update', 'NovelsController@update');
$router->addRoute('POST', '/novel/delete', 'NovelsController@delete');
$router->addRoute('GET', '/novel/fetch', 'NovelsController@fetch');
// chapters routes
$router->addRoute('GET', '/chapters/create', 'ChaptersController@create');
$router->addRoute('POST', '/chapters/store', 'ChaptersController@store');
$router->addRoute('GET', '/chapters/edit', 'ChaptersController@edit');
$router->addRoute('POST', '/chapters/update', 'ChaptersController@update');
$router->addRoute('POST', '/chapters/delete', 'ChaptersController@delete');
$router->addRoute('GET', '/chapters/fetch', 'ChaptersController@fetch');