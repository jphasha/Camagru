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

    <p>Hello <a href="includes/profile.php?user=<?php echo escape($user->data()->user_name); ?>"><?php echo escape($user->data()->user_name); ?></a>!</p>

    <ul>
        <li><a href="logout.php">Log out</a></li>
        <li><a href="update.php">Update</a></li>
        <li><a href="changepassword.php">change password</a></li>
    </ul>

<?php
    if ($user->hasPermission('admin'))
    {
        echo '<p>You are an admin.</p>';
    }
}
else
{
    echo '<p>You need to <a href="login.php">Log in</a> or <a href="register.php">Register</a></p>';
?>
<div>
    <a href="view_gal.php">Gallery</a>
</div>
<?php
}
?>