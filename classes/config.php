<?php
class Config
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
                echo $element."<br>";
                if (isset($config[$element]))
                {
                    echo ":".$element."<br>";
                    $new_path = $config[$element];
                    foreach ($new_path as $new_element)
                    {
                        echo "::".$new_element."<br>";
                    }
                }
                else
                {
                    echo ": not an element <br>";
                }
            }
            
        }
    }
}
?>