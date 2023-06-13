<?php

use Shappy\Utils\FlashMessage;


function session()
{
    return new FlashMessage;
}

// url, uri, path
function redirect($location)
{
    header("Location: $location"); exit;
}

function back()
{
    header("Location: {$_SERVER['REQUEST_URI']}"); exit;
}


function img($img_name) {
    return "/assets/images/$img_name";
}

// request
function old($field, $default = null)
{
    if (isset($_SESSION['_old_input']) && isset($_SESSION['_old_input'][$field])) 
        return $_SESSION['_old_input'][$field];
    return $default;
}


// auth && Authorization

function auth()
{
    return isset($_SESSION['auth']) ? $_SESSION['auth'] : null;
}

function is_authorized()
{
    return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
}

function is_guest()
{
    return !isset($_SESSION['is_logged_in']);
}


function is_owner($user_id) {
    return auth()->id == $user_id;
}



// error pages
function error_403($msg = null) {
    $error_msg = $msg;
    include_once 'views/403.php'; exit;
}

function error_404($msg = null) {
    $error_msg = $msg;
    include_once 'views/404.php'; exit;
}

