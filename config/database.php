<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$DB = 'retest';
$HOST = 'localhost';
$DB_DSN = 'mysql:dbname=' . $DB . ';host=' . $HOST;//Data Source Name: the database we wish to connect to within our server/host.
$DB_USER = 'root';//the user who is accessing the server and database.
$DB_PASSWORD = '';//user's password.

//now to connect to the database.
// try
// {
//     $connection = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);//establishing a new connection.
//     $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//set error mode to exception.
// }
// catch(PDOException $exception)
// {
//     echo "connection failed because :" . $exception->getMessage();
// }
?>