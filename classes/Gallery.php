<?php
class Gallery
{
    public $path;

    public function __construct()
    {
        $this->path = __DIR__ . '/images';
    }

    public function setPath($path)
    {
        // if (substr($path, -1) === '/') // if the last charater is '/';
        // {
        //     $path = substr($path, 0, -1); // remove the last character;
        // }
        echo $this->path = $path;
    }
}
?>