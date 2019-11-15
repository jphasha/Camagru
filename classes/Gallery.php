<?php
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
        echo $this->path = $path;
    }

    private function getDirectory($path)
    {
        return scandir($path);
    }

    public function getImages($extensions = array('jpg', 'png', 'jpeg'))
    {
        $images = $this->getDirectory($this->path);

        foreach ($images as $index => $image)
        {
            $extension = strtolower(end(explode('.', $image))) . "<br>";
            if (in_array($extension, $extensions))
            {
                unset($images[$index]);
            }
            else
            {
                $images[$index] = array()
            }
        }

        return $images;
    }
}
?>