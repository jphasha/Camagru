<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Gallery
{
    private $_db,
            $_likes;

    public function __construct()
    {
        $this->_db = DB::getInstance();
        $this->_likes = $this->_db->get('likes', ['like_id', '>', 0]);
    }

    public function getLikes()
    {
        return $this->_likes;
    }
}
?>