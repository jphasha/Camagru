<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../core/initialise.php';

if (isset($_GET['type'], $_GET['id']))
{
    $type = $_GET['type'];
    $id = (int)$_GET['id']; // an id is always a number, so we cast it to an int.

    switch($type)
    {
        case 'file':
            $db->query(
            "INSERT INTO likes (picture_id, liker_id) 
            SELECT {}, {Session::get('name')}"
            );
        break;
    }
}
?>