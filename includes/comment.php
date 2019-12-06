<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../core/initialise.php';

$test = DB::getInstance();

if (isset($_POST['comment_btn']))
{
    $test->insert('comments', [
        'picture_id' => $_POST['img_id'],
        // 'user_id' => 1,
        'commentor_id' => Session::get('user'),
        'comment' => $_POST['right']
    ]);
}

Redirect::to('view_gal.php');
?>