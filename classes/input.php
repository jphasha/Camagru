<?php
class Input
{
    public static function exists($type = 'post')
    {
        switch($type)
        {
            case 'post':
                echo "post<br>";
                return (!empty($_POST)) ? true : false;
            break;
            case 'get':
                echo "get<br>";
                return (!empty($_GET)) ? true : false;
            break;
            default:
                echo "not set<br>";
                return false;
            break;
        }
    }

    public static function get($item)
    {
        if (isset($_POST[$item]))
        {
            return $_POST[$item];
        }
        else if (isset($_GET[$item]))
        {
            return $_GET[$item];
        }
        else
        {
            return '';
        }
    }
}
?>