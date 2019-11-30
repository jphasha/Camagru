<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../core/initialise.php';

$user = new User(); // call the user class.
$user->logout(); // use the logout method in the user class to delete the current session.

Redirect::to('../index.php') // redirect to index.php which will give the option to either log in or sign in.
?>