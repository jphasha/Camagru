<?php
require_once '../core/initialise.php';

$user = new User(); // call the user class.
$user->logout(); // use the logout method in the user class to delete the current session.

Redirect::to('../index.php') // redirect to index.php which will give the option to either log in or sign in.
?>