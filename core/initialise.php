<?php
// for now it is in everybody's best interest if we don't talk about this file.
session_start(); //allows for people to login. without a session, login is impossible.

//now we are creating a config class which will allow us to:
$GLOBALS['config'] = array
(
    // connect to our database.
    'mysql' => array
    (
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'db' => 'db_jphasha'
    ),
    // setup cookies.
    'remember' => array
    (
        'cookie_name' => 'my_cookie',
        'cookie_expiry' => 3600 //setup to an hour.
    ),
    // setup a session.
    'sessions' => array
    (
        'session' => 'user_session'
    )
);
// ?????
spl_autoload_register
(
    function($class)
    {
        require_once 'classes/' . $class . '.php';// ???????
    }
);

require_once 'functions/sanitize.php';
?>