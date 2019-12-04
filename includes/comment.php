<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../core/initialise.php';

$test = DB::getInstance();

if (isset($_POST['comment_btn']))
{
    echo "commented<br>";
    echo $_POST['right'] . "<br>";

    // echo '<pre>';
    // var_dump($_POST);
    // echo '</pre>';

    die('okay');

    $test->insert('comments', [
        'picture_id' => 1,
        'user_id' => 1,
        'commentor_id' => 1,
        'comment' => $_POST['right']
    ]);
}
?>