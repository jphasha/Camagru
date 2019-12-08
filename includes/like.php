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
        $db->insert('likes', array(
            'picture_id' => $_POST['img_id'],
            'liker_id' => Session::get('user')
        ));
    }
    else {
        $db->delete(
            'likes',
            ['liker_id', '=', Session::get('user')]
        );
    }
}

Redirect::to('view_gal.php');
?>