<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Gallery
{
    public $path;
    private $_db;

    public function __construct()
    {
        $this->path = __DIR__ . '/../uploads';
        $this->_db = DB::getInstance();
    }

    public function setPath($path)
    {
        if (substr($path, -1) === '/') // if the last charater is '/';
        {
            $path = substr($path, 0, -1); // remove the last character;
        }
        $this->path = $path;
    }

    public function getImages()
    {
        $imgObj = $this->_db->get('pictures', ['picture_id', '>', 0]); // returns an array of results refer db class
        $i = 0;
        $img = [];

        while ($i < $imgObj->count())
        {
            $img[$i] =  [
                'full' => $this->path . '/' . $imgObj->results()[$i]->picture_name
                // 'thumb' => $this->path . '/thumbs/' . $image
            ];
            $i += 1;
        }
        return (count($img)) ? $img : false;
    }
}
?>