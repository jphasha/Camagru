<?php
require_once 'core/initialise.php';

if (Input::exists())
{
    if (Token::check(Input::get('token')))
    {
        // echo "i have been run<br>"; //because we are not yet able to generate token, we are not able to enter this part of the code.
        // echo Input::get('token') . "<br>"; // not echoing this variable even though it is suppossed to. again NVM, the connection to the sessions was the issue.
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users'
            ),
            'email' => array(
                'required' => true,
                'unique' => 'users'
            ),
            'password' => array(
                'required' => true,
                'min' => 8
            ),
            'confirm_password' => array(
                'required' => true,
                'matches' => 'password'
            )
            )
        );
        if ($validation->passed())
        {
            // Session::flash('success', 'Registration Successful!'); // a flash message to be displayed.
            // header('Location: index.php'); // a direction to go to after the user has been successfully registered.
        }
        else
        {
            foreach ($validation->errors() as $error)
            {
                echo $error . "<br>";
            }
        }
    }
}
?>

<form action="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off">
    </div>
    <div class="field">
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="<?php echo escape(Input::get('email')); ?>">
    </div>
    <div class="field">
        <label for="password">Create a password</label>
        <input type="text" name="password" id="password">
    </div>
    <div class="field">
        <label for="Confirm Password">Confirm your Password</label>
        <input type="text" name="confirm_password" id="confirm_password">
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <!-- no token generated. nevermind, i was directing the $_SESSION[config] to sessions wrong.--> 
    <input type="submit" value="Register">
</form>