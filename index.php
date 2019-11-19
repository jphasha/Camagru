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

    <p>Hello <a href="#"><?php echo escape($user->data()->user_name); ?></a>!</p>

    <ul>
        <li><a href="logout.php">Log out</a></li>
        <li><a href="update.php">Update</a></li>
    </ul>

<?php
}
else
{
    echo '<p>'You need to <a href="login.php">Log in</a> or <a href="register.php">Register</a>'</p>';
}
?>