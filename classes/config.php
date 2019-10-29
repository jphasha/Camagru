<?php
class Config
{
    public static function get($path = null)
    {
        if ($path)
        {
            $config = $GLOBALS['config'];
            $path = explode('/', $path);
            print_r($GLOBALS);
            echo "<br>";
            print_r($path);
        }
    }
}
?>