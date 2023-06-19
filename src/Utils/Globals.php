<?php

use Shappy\Utils\FlashMessage;

function url($uri = '')
{
    if (HOME_URL == '/')
        return "/$uri";
    return HOME_URL . "/$uri";
}

function session()
{
    return new FlashMessage;
}

function img($img_name)
{
    if (HOME_URL == '/')
        return "/assets/images/$img_name";
    return HOME_URL . "/assets/images/$img_name";
}

function asset($asset)
{
    if (HOME_URL == '/')
        return "/assets/$asset";
    return HOME_URL . "/assets/$asset";
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


function is_owner($user_id)
{
    return auth()->id == $user_id;
}



// error pages
function error_403($msg = null)
{
    $error_msg = $msg;
    include_once 'views/403.php';
    exit;
}

function error_404($msg = null)
{
    $error_msg = $msg;
    include_once 'views/404.php';
    exit;
}

//str

function excerpt($text, $max_length)
{
    if (strlen($text) > $max_length) {
        $text = substr($text, 0, $max_length) . "...";
    }

    return $text;
}
