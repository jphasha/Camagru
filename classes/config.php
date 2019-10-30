<?php
class Config //what this function does is return the host path or really any path it is directed towards. but what it does is check if the path exists.
{
    public static function get($path = null)
    {
        if ($path)
        {
            // properties / variables
            $config = $GLOBALS['config']; //remember, $GLOBALS is a global variable so it can be called without requiring the file it is declared in(i think).
            $path = explode('/', $path);
            // print_r($GLOBALS);
            // echo "<br>";
            // print_r($path);
            // echo "<br>";

            // now printing the above arrays in a while loop.
            foreach ($path as $element)
            {
                if (isset($config[$element]))
                {
                    $config = $config[$element]; // under ideal circumstances, localhost will be returned.(for the purposes of this project ofcourse.)
                }
            }
            return $config;
        }
        return false;
    }
}
?>