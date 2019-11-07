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
// DataBase::getInstance()->query("INSERT INTO users(user_name, user_email) VALUES ('roman', 'roman@romemail.com')");// the database class has been successfully instantiated. and data insertion into table successful.
// $users = DataBase::getInstance()->delete('users', array('user_email' => 'po', 'user_name' => 'kfjh', 'user_pass' => 'ffff'));
// echo $users->first()->user_name;
// echo '<pre>', var_dump($users->first()), '<pre>'; // the results function is acting up so for now if i want to see the results of my query but i will be back.
// $update = DataBase::getInstance()->update('users', 33, array('full_name' => 'kopi_ya_tswikiri', 'user_pass' => 'A_good_9455'))
if (Session::exists('home'))
{
    echo '<p>' . Session::flash('home') . '<p>';
}
?>