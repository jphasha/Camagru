<?php

require_once '../core/initialise.php';

if (Input::exists())
{
    if (Token::check(Input::get('token')))
    {
        // echo "i have been run<br>"; //because we are not yet able to generate token, we are not able to enter this part of the code.
        // echo Input::get('token') . "<br>"; // not echoing this variable even though it is suppossed to. again NVM, the connection to the sessions was the issue.
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'firstname' => array( // key values must match the field names in the form (login/register form);
                'required' => true,
                'min' => 2,
                'max' => 50,
            ),
            'lastname' => array(
                'required' => true,
                'min' => 2,
                'max' => 50,
            ),
            'user_name' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users' // 'users' in this case being the table 'users' in the database.
            ),
            'user_email' => array(
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
                        'user_email' => Input::get('user_email'),
                        'user_name' => Input::get('user_name'),
                        'user_pass' => Hash::make(Input::get('password'), "salt"),
                        'joined' => date('Y-m-d H:i:s'),
                        'group' => 1,
                        'salt' => "salt"
                    )
                );

                $email = Input::get('user_email');
                $username = Input::get('user_name');
                $subject = 'Signup | Verification';
                $message = 'Thank you for registerimg. Please click the link to verify your registration:';
                $message .= "\r\n";
                $message .= "<a href='http://localhost:8080/projects_github/github_camagru/login.php?user=$username&salt=$salt'>Register Account</a>";
                $headers = 'From:kingjoe@mailinator.com' . "\r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-Type:text/html;charset=UTF-8". "\r\n";
                mail($email, $subject, $message, $headers);

                Session::flash('home', 'you are now registered');

                Redirect::to('verify.php'); // direct the user to the homepage / index.php.
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
        <label for="user_email">Email</label>
        <input type="text" name="user_email" id="user_email" value="<?php echo escape(Input::get('user_email')); ?>" required>
    </div>
    <div class="field">
        <label for="user_name">Username</label>
        <input type="text" name="user_name" id="user_name" value="<?php echo escape(Input::get('user_name')); ?>" autocomplete="off" required>
    </div>
    <div class="field">
        <label for="password">Create a Password</label>
        <input type="password" name="password" id="password" required>
    </div>
    <div class="field">
        <label for="confirm_password">Confirm your Password</label>
        <input type="password" name="confirm_password" id="confirm_password" required>
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <!-- no token generated. nevermind, i was directing the $_SESSION[config] to sessions wrong.--> 
    <input type="submit" value="Register">
</form>