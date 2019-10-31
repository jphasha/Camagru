<?php
require_once 'core/initialise.php';

// echo Config::get('mysql/host'); //"::" the double colons are the "->" sccessing method to access a static function (or a variable).
// basically, right now i'm just calling the function get from the class Config. i'm trying to get the path or address of my host.

// $users = DataBase::getInstance()->query('SELECT user_name FROM users');//instantiate the class DataBase and use the mysql query to get the column "user_name" from the table "users".
// if ($users->count())// if there are users.
// {
//     foreach ($users as $user)//we will iterate through an array of $users where we will refer to each user(iteration) as $user.
//     {
//         echo $user->user_name;
//     }
// }
DataBase::getInstance()->query("INSERT INTO users(user_name, user_email) VALUES ('harrison', 'tuhyr@mail.com')");// the database class has been successfully instantiated. and data insertion into table successful.
DataBase::getInstance()->query("INSERT INTO users(user_name, user_email) VALUES ('king', 'plotyr@mail.com')");
?>