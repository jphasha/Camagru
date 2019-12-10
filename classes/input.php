<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Input
{
    public static function exists($type = 'post') // setting the default input method to 'post'.
    {
        switch($type)
        {
            case 'post':
                return (!empty($_POST)) ? true : false;
            break;
            case 'get':
                return (!empty($_GET)) ? true : false;
            break;
            default:
                return false;
            break;
        }
    }

    public static function get($item)
    {
        if (isset($_POST[$item]))
        {
            return escape($_POST[$item]);
        }
        else if (isset($_GET[$item]))
        {
            return escape($_GET[$item]);
        }
        else
        {
            return '';
        }
    }
}
?>