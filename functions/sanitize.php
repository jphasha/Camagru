<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function escape($input)//a function used to escape undesired characters. to prevent against SQL injections.
{
    return htmlentities($input, ENT_QUOTES, 'UTF-8');
    // $input = what needs to be sanitized / filtered to remove any undesirable characters from.
    // ENT_QUOTES = a parameter responsible for removing the (''"") quotes.
    // to encrypt incoming / outgoing data.
}
?>