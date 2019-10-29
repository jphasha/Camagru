<?php
require_once 'config/database.php';

// $users = DB::getInstance()->query('SELECT user_nmae FROM users');
echo '<pre>', var_dump($connection), '</pre>'; //successfully linked database.php to index.php
?>