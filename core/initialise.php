<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// for now it is in everybody's best interest if we don't talk about this file.
session_start(); //allows for people to login. without a session, login is impossible.

//now we are creating a config class which will allow us to:
$GLOBALS['config'] = array(
    // connect to our database.
    'mysql' => array(
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'db' => 'db_jphasha'
    ),
    // setup cookies.
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 3600 //setup to an hour.
    ),
    // setup a session.
    'sessions' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    )
);
// the spl_autoload_register in this case, is used to require classes in the "index.php".
spl_autoload_register
(
    function($class)
    {
        require_once ($_SERVER['DOCUMENT_ROOT'] . '/projects_github/github_camagru/classes/' . $class . '.php');
    }
);

require_once ($_SERVER['DOCUMENT_ROOT'] . '/projects_github/github_camagru/functions/sanitize.php'); // gonna need a better redirection on this one.

if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('sessions/session_name')))
{
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));

    if ($hashCheck->count())
    {
        $user = new User($hashCheck->first()->user_id);
        $user->login();
    }
}
?>