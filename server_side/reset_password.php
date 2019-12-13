<?php

require_once '../core/initialise.php';

if (isset($_POST['reset']))
{
    $db = DB::getInstance();
    $email = Input::get('email');
    $salt = Input::get('token');
    $email_exist = 
    // $email_db = ;
    var_dump($db->get('users', ['user_email', '=', 'jlpv57@gmail.com'])->results());
    echo "<br>";
    var_dump($_POST);
    die("<br>okay<br>");
}
?>