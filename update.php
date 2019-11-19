<?php
require_once 'core/initialise.php';

$user = new User();

if (!$user->isLoggedIn())
{
    Redirect::to('index.php');
}
?>

<form action="" method="post">
    <div class="field">
        <label for="user_name">User Name</label>
        <input type="text" name="user_name" value="<?php echo escape($user->data()->user_name); ?>">

        <input type="submit" value="Update">
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    </div>
</form>