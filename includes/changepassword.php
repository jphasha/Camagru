<?php
require_once '../core/initialise.php';

$user = new User();

if (!$user->isLoggedIn())
{
    Redirect::to('../index.php');
}

if (Input::exists())
{
    if (Token::check(Input::get('token')))
    {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'current_password' => array(
                'required' => true,
                'min' => 8
            ),
            'new_password' => array(
                'required' => true,
                'min' => 8
            ),
            'confirm_new_password' => array(
                'required' => true,
                'min' => 8,
                'matches' => 'new_password'
            )
            )
        );

        if ($validation->passed())
        {
            if (Hash::make(Input::get('current_password') . $user->data()->salt) !== $user->data()->user_pass)
            {
                echo "your current password is wrong.<br>";
            }
            else
            {
                $salt = Hash::salt(32);
                $user->update(array(
                    'password' => Hash::make(Input::get('new_password') . $salt),
                    'salt' => $salt
                )
            );

            Session::flash('home', 'password changed');

            Redirect::to('../index.php');
            }
        }
        else
        {
            foreach($validation->errors() as $error)
            {
                echo $error . "<br>";
            }
        }
    }
}
?>

<form action="" method="post">
    <div class="field">
        <label for="current_password">current password</label>
        <input type="password" name="current_password" id="current_password">
    </div>

    <div class="field">
        <label for="new_password">new password</label>
        <input type="password" name="new_password" id="new_password">
    </div>
    <div class="field">
        <label for="confirm_new_password">confirm new password</label>
        <input type="password" name="confirm_new_password" id="confirm_new_password">
    </div>

    <input type="submit" value="change">
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
</form>