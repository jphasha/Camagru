<?php
require_once 'core/initialise.php';

echo Config::get('mysql/host'); //"::" the double colons are the "->" sccessing method to access a static function (or a variable).
// basically, right now i'm just calling the function get from the class Config. i'm trying to get the path or address of my host.
?>