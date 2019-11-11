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
            'firstname' => array(
                'required' => true,
                'min' => 2,
                'max' => 50,
            ),
            'lastname' => array(
                'required' => true,
                'min' => 2,
                'max' => 50,
            ),
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users'
            ),
            'useremail' => array(
                'required' => true,
                'unique' => 'users',
                'min' => 2,
                'max' => 50
            ),
            'password' => array(
                'required' => true,
                'min' => 8,
                'max' => 50
            ),
            'confirm_password' => array(
                'required' => true,
                'matches' => 'password'
            )
            )
        );
        if ($validate->passed()) // $validate NOT $validation
        {
            // echo "word<br>";
            // Session::flash('success', 'Registration Successful!'); // a flash message to be displayed.
            // header('Location: index.php'); // a direction to go to after the user has been successfully registered.
            $user = new User();

            try
            {
                $user->create(
                    array(
                        'first_name' => Input::get('firstname'),
                        'last_name' => Input::get('lastname'),
                        'user_email' => Input::get('email'),
                        'user_name' => Input::get('username'),
                        'user_pass' => Hash::make(Input::get('password'), "salt"),
                        'joined' => date('Y-m-d H:i:s'),
                        'group' => 1,
                        'salt' => "salt"
                    )
                );

                Session::flash('home', 'you are now registered');

                Redirect::to('index.php'); // direct the user to the homepage / index.php.
            }
            catch (Exception $some_exception)
            {
                echo "here?<br>";
                die ($some_exception->getMessage()); // this is usually where you create and redirect users to som page named 404 or something. remember, you must always control where your visitors are directed.
            }
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
        <label for="firstname">First Name(s)</label>
        <input type="text" name="firstname" id="firstname" value="<?php echo escape(Input::get('firstname')); ?>" required>
    </div>
    <div class="field">
        <label for="lastname">Last Name</label>
        <input type="text" name="lastname" id="lastname" value="<?php echo escape(Input::get('lastname')); ?>" required>
    </div>
    <div class="field">
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="<?php echo escape(Input::get('email')); ?>" required>
    </div>
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off" required>
    </div>
    <div class="field">
        <label for="password">Create a Password</label>
        <input type="text" name="password" id="password" required>
    </div>
    <div class="field">
        <label for="Confirm Password">Confirm your Password</label>
        <input type="text" name="confirm_password" id="confirm_password" required>
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <!-- no token generated. nevermind, i was directing the $_SESSION[config] to sessions wrong.--> 
    <input type="submit" value="Register">
</form>