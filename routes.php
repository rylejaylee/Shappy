<?php

use Shappy\Http\Router;
$router = new Router;
$home = HOME_URL;

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
$router->addRoute('POST', '/novel/upload_cover', 'NovelsController@upload_cover');
// chapters routes
$router->addRoute('GET', '/chapters/create', 'ChaptersController@create');
$router->addRoute('POST', '/chapters/store', 'ChaptersController@store');
$router->addRoute('GET', '/chapters/edit', 'ChaptersController@edit');
$router->addRoute('POST', '/chapters/update', 'ChaptersController@update');
$router->addRoute('POST', '/chapters/delete', 'ChaptersController@delete');
$router->addRoute('GET', '/chapters/fetch', 'ChaptersController@fetch');
$router->addRoute('GET', '/chapters/all', 'ChaptersController@all');
$router->addRoute('GET', '/chapters/fetch_next', 'ChaptersController@next');
$router->addRoute('GET', '/chapters/fetch_prev', 'ChaptersController@previous');
$router->addRoute('GET', '/chapters/read_first', 'ChaptersController@read_first');
// reviews routes
$router->addRoute('POST', '/reviews/store', 'ReviewsController@store');
$router->addRoute('POST', '/reviews/update', 'ReviewsController@update');
$router->addRoute('POST', '/reviews/delete', 'ReviewsController@delete');
// ratings routes
$router->addRoute('POST', '/rating/store', 'RatingsController@store');
$router->addRoute('POST', '/rating/update', 'RatingsController@update');
$router->addRoute('POST', '/rating/user_rating', 'RatingsController@user_rating');
// pages routes
$router->addRoute('GET', '/novels/list', 'PagesController@list');
$router->addRoute('POST', '/novels/search', 'PagesController@search');
$router->addRoute('GET', '/novels/genre', 'PagesController@genre');
$router->addRoute('GET', '/novels/advance_search', 'PagesController@advance_search');
// library routes
$router->addRoute('GET', '/library', 'LibraryController@index');
$router->addRoute('GET', '/library/add', 'LibraryController@add');
$router->addRoute('GET', '/library/remove', 'LibraryController@remove');
// settings routes
$router->addRoute('GET', '/settings', 'SettingsController@index');
$router->addRoute('POST', '/users/update', 'SettingsController@update_user');