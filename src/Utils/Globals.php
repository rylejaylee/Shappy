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

function img($img_name = "")
{
    if (HOME_URL == '/')
        return "/assets/images/$img_name";
    return HOME_URL . "/assets/images/$img_name";
}

function asset($asset = "")
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

// time
function hummanDiff($timestamp)
{
    $currentTimestamp = time();
    $difference = $currentTimestamp - strtotime($timestamp);

    $diffInSeconds = $difference;
    $diffInMinutes = floor($difference / 60);
    $diffInHours = floor($difference / (60 * 60));
    $diffInDays = floor($difference / (60 * 60 * 24));
    $diffInMonths = floor($difference / (60 * 60 * 24 * 30));
    $diffInYears = floor($difference / (60 * 60 * 24 * 365));

    if ($diffInYears > 0) {
        $humanDifference = $diffInYears . " year(s) ago";
    } elseif ($diffInMonths > 0) {
        $humanDifference = $diffInMonths . " month(s) ago";
    } elseif ($diffInDays > 0) {
        $humanDifference = $diffInDays . " day(s) ago";
    } elseif ($diffInHours > 0) {
        $humanDifference = $diffInHours . " hour(s) ago";
    } elseif ($diffInMinutes > 0) {
        $humanDifference = $diffInMinutes . " minute(s) ago";
    } else {
        $humanDifference = $diffInSeconds . " second(s) ago";
    }

    return $humanDifference;
}


function number_format_short($n, $precision = 1)
{
    if ($n < 900) {
        // 0 - 900
        $n_format = number_format($n, $precision);
        $suffix = '';
    } elseif ($n < 900000) {
        // 0.9k-850k
        $n_format = number_format($n * 0.001, $precision);
        $suffix = 'K';
    } elseif ($n < 900000000) {
        // 0.9m-850m
        $n_format = number_format($n * 0.000001, $precision);
        $suffix = 'M';
    } elseif ($n < 900000000000) {
        // 0.9b-850b
        $n_format = number_format($n * 0.000000001, $precision);
        $suffix = 'B';
    } else {
        // 0.9t+
        $n_format = number_format($n * 0.000000000001, $precision);
        $suffix = 'T';
    }

    // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
    // Intentionally does not affect partials, eg "1.50" -> "1.50"
    if ($precision > 0) {
        $dotzero = '.' . str_repeat('0', $precision);
        $n_format = str_replace($dotzero, '', $n_format);
    }

    return $n_format . $suffix;
}


function user_initials()
{
    $nameArray = explode(' ', auth()->name);
    if (count($nameArray) == 1) {
        return ucwords($nameArray[0][0]);
    }

    return ucwords("{$nameArray[0][0]}{$nameArray[1][0]}");
}
