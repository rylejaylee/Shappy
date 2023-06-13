<?php

namespace Shappy\Utils;

class Guard
{
    public static function guest()
    {
        if (is_authorized()) error_403();
    }

    public static function authorized()
    {
        if (!is_authorized()) error_403();
    }

    public static function owner($user_id)
    {
        if (auth()->id != $user_id) error_403("Unauthorized access");
    }

    public static function can($condition)
    {
        if (!$condition) error_403("Unauthorized access");
    }
}
