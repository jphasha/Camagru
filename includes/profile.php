<?php
require_once '../core/initialise.php';

if (!$username = Input::get('user'))
{
    Redirect::to('index.php');
}
else
{
    $user = new User($username);
    if (!$user->exists())
    {
        Redirect::to('errors/404.php');
    }
    else
    {
        $data = $user->data();
    }
    ?>

    <h3>
        <?php echo escape($data->username); ?>
    </h3>
    <p>Full name: <?php echo escape($data->firstname); ?> <?php echo escape($data->lastname); ?>
    </p>
    <?php
}
?>