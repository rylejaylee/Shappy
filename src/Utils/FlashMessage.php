<?php

namespace Shappy\Utils;

class FlashMessage
{
    /**
     * Set a flash message.
     *
     * @param string $key   The key or name of the flash message.
     * @param mixed  $value The value of the flash message.
     */
    public static function set($key, $value)
    {
        $_SESSION['flash'][$key] = $value;
    }

    /**
     * Get a flash message by key and remove it.
     *
     * @param string $key The key or name of the flash message.
     * @return mixed|null The flash message value or null if not found.
     */
    public static function get($key)
    {
        if (isset($_SESSION['flash'][$key])) {
            $value = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $value;
        }
        return null;
    }

    /**
     * Check if a flash message with the given key exists.
     *
     * @param string $key The key or name of the flash message.
     * @return bool True if the flash message exists, false otherwise.
     */
    public static function has($key)
    {
        return isset($_SESSION['flash'][$key]);
    }

    /**
     * Keep all flash messages for another request.
     */
    public static function keep()
    {
        $_SESSION['flash.keep'] = true;
    }

    /**
     * Clear all flash messages.
     */
    public static function clear()
    {
        unset($_SESSION['flash']);
        unset($_SESSION['flash.keep']);
    }
}
?>