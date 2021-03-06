<?php

require_once 'config/setup.php';

require_once 'core/initialise.php';

// if (Session::exists('home'))
// {
//     echo '<p>' . Session::flash('home') . '</p>';
// }

$user = new User();

if ($user->isLoggedIn())
{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" href="includes/style.css">
</head>
<body>
    <header class="header">

        <button><a href="index.php">Home</a></button>
        <button><a href="includes/view_gal.php">Gallery</a></button>
        <button><a href="includes/logout.php">Log out</a></button>
        <button><a href="includes/update.php">Update</a></button>
        <button><a href="includes/changepassword.php">change password</a></button>
        <button><a href="includes/upload.php">Upload a picture</a></button>
        <button><a href="includes/new_webcam.php">take a picture</a></button>
    
    </header>

    <p>Hello <a href="includes/profile.php?user=<?php echo escape($user->data()->user_name); ?>"><?php echo escape($user->data()->user_name); ?></a>!</p>
    
    <footer class="footer">
    &copy; jphasha 2019
    </footer>
</body>
</html>
<?php
}

else
{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Root</title>
    <link rel="stylesheet" href="includes/style.css">
</head>
<body>
    <header class="header">
    </header>
    <div class="root_field">
        <p>
            <?php echo '<p>You need to <a href="includes/login.php">Log in</a> or <a href="includes/register.php">Register</a></p>'; ?>
        </p>
        <a href="includes/view_gal.php">Gallery</a>
    </div>
    <footer class="footer">
    &copy; jphasha 2019
    </footer>
</body>
</html>
<?php
}
?>