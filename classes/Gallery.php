<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Gallery
{
    public $path;

    public function __construct()
    {
        $this->path = __DIR__ . '\images';
    }

    public function setPath($path)
    {
        if (substr($path, -1) === '/') // if the last charater is '/';
        {
            $path = substr($path, 0, -1); // remove the last character;
        }
        $this->path = $path;
    }

    private function getDirectory($path)
    {
        return scandir($path);
    }

    public function getImages()
    {
        $images = $this->getDirectory($this->path);

        foreach ($images as $index => $image)
        {
            $sep_data = explode('.', $image);
            $extension = strtolower(end($sep_data));
            if (!in_array($extension, array('jpg', 'png', 'jpeg')))
            {
                unset($images[$index]);
            }
            else
            {
                $images[$index] = array(
                    'full' => $this->path . '/' . $image
                    // 'thumb' => $this->path . '/thumbs/' . $image
                );
            }
        }

        return (count($images)) ? $images : false;
    }
}
?>