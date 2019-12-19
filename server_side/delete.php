<?php
require_once '../core/initialise.php';

$gallery = new Gallery();

if (isset($_POST['del_but']))
{
    $gallery->deletePicture(Input::get('picture_id'));
}

Redirect::to('../includes/new_webcam.php');
?>