<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

class Session
{
    public static function exists($name)
    {
        return (isset($_SESSION[$name])) ? true : false;
    }

    public static function put($name, $value)
    {
        return $_SESSION[$name] = $value;
    }

    public static function get($name)
    {
        return $_SESSION[$name];
    }
    public static function delete($name)
    {
        if (self::exists($name))
        {
            unset($_SESSION[$name]);
        }
    }

    public static function flash($name, $string = '') //send a message that will disappear after refresh.
    // $name = name of the flash data, $string = contents of the flash data.
    // flash message example: "you have been successfully registered as a user."
    // there is absolutely no need to repeat this message everytime the user login.
    {
        if (self::exists($name)) // does the session exists.
        {
            $session = self::get($name);
            self::delete($name);
            return $session;
        }
        else
        {
            self::put($name, $string);
        }
    }
}
?>