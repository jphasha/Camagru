<?php
require_once 'core/initialise.php';

if (Session::exists('home'))
{
    echo '<p>' . Session::flash('home') . '</p>';
}

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
    </header>

    <p>Hello <a href="includes/profile.php?user=<?php echo escape($user->data()->user_name); ?>"><?php echo escape($user->data()->user_name); ?></a>!</p>

    <ul>
        <li><a href="includes/logout.php">Log out</a></li>
        <li><a href="includes/update.php">Update</a></li>
        <li><a href="includes/changepassword.php">change password</a></li>
    </ul>
    
    <footer class="footer">
    &copy; jphasha 2019
    </footer>
</body>
</html>
<?php
    if ($user->hasPermission('admin'))
    {
        echo '<p>You are an admin.</p>';
    }
}
else
{
    echo '<p>You need to <a href="includes/login.php">Log in</a> or <a href="includes/register.php">Register</a></p>';
?>
<div>
    <a href="includes/view_gal.php">Gallery</a>
</div>
<?php
}
?>