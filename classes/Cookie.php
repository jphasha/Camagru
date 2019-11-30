<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Cookie
{
    public static function exists($name)
    {
        if (isset($_COOKIE[$name]))
        {
            return true;
        }
        return false;
    }

    public static function get($name)
    {
        return $_COOKIE[$name];
    }

    public static function put($name, $value, $expiry)
    {
        if (setcookie($name, $value, time() + $expiry, "/")) // the "/" character is to signify that the cookie is available on the whole website.
        {
            return true;
        }
        return false;
    }

    public static function delete($name)
    {
        self::put($name, '', time() - 1);
    }
}
?>