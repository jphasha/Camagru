<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../core/initialise.php';

if (!$username = Input::get('user'))
{
    Redirect::to('../index.php');
}

else
{
    $user = new User($username);
    if (!$user->exists())
    {
        Redirect::to('../errors/404.php');
    }
    else
    {
        $data = $user->data();
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Profile page</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <header class="header">

            <button><a href="../index.php">Home</a></button>
            <button><a href="view_gal.php">Gallery</a></button>
            <button><a href="logout.php">Log out</a></button>
            <button><a href="update.php">Update</a></button>
            <button><a href="changepassword.php">change password</a></button>
            <button><a href="upload.php">Upload a picture</a></button>
            <button><a href="new_webcam.php">take a picture</a></button>

        </header>
        <h3>
            <?php echo escape($data->user_name); ?>
        </h3>
        <p>
            Full name: <?php echo escape($data->first_name); ?> <?php echo escape($data->last_name); ?>
        </p>
    </body>
    </html>
    <?php
}
?>