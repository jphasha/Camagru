<?php
session_start(); //allows for people to login. without a session, login is impossible.

//now we are creating a config class which will allow us to
$GLOBALS['config'] = array
(
    'mysql' => array(),
    'remember' => array(),
    'sessions' => array()
)
?>