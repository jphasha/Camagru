<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../core/initialise.php';

$db = DB::getInstance();
if (isset($_POST['like']))
{
    $gallery = new Gallery();
    if ($gallery->getLikes(Session::get('user'), $_POST['img_id']) === 0)
    {
        $gallery->likePictures($_POST['img_id'], Session::get('user'));
    }
    else {
        $gallery->deleteLikes($_POST['img_id'], Session::get('user'));

        // $db->delete(
        //     'likes',

        //     // ['liker_id', '=', Session::get('user')]   // had to remove this one because it removes all the likes in the table.
        //     // ['picture_id', '=', $_POST['img_id']]     // this one also removes all the likes associated with that picture.
        // );
    }
}

Redirect::to('view_gal.php');
?>