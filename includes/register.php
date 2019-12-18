<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../core/initialise.php';

if (Input::exists())
{
    $salt = Input::get('token');
    if (Token::check($salt))
    {
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
                'max' => 50,
                'strong_pattern' => 'lower and upper case'
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
                        // 'user_pass' => Hash::make(Input::get('password'), "salt"),
                        'user_pass' => password_hash(Input::get('password'), PASSWORD_DEFAULT),
                        'joined' => date('Y-m-d H:i:s'),
                        'group' => 1,
                        'salt' => $salt,
                        // 'verified' => 0
                    )
                );
                
                $email = Input::get('user_email');
                $username = Input::get('user_name');
                $subject = 'Registration Verification';
                $message = 'Thank you for registerimg. Please click the link to verify your registration:';
                $message .= "\r\n";
                $message .= "<a href='http://localhost:8080/projects_github/github_camagru/includes/login.php?user=$username&salt=$salt'>Register Account</a>";
                $headers = 'From:noreply@themail.com' . "\r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-Type:text/html;charset=UTF-8". "\r\n";
                mail($email, $subject, $message, $headers);

                Session::flash('home', 'you are now registered');

                Redirect::to('verify.php'); // the verification mail will handle the direction to home / index.php.
            }
            catch (Exception $some_exception)
            {
                // die ($some_exception->getMessage()); // this is usually where you create and redirect users to som page named 404 or something. remember, you must always control where your visitors are directed.
                Redirect::to('404');
            }
        }
        else
        {
            foreach ($validation->errors() as $error)
            {
                echo '<script>console.log("me");</script>';
                echo $error . "<br>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <button><a href="../index.php">Home</a></button>
        <button><a href="view_gal.php"></a></button>
    </header>
    <div class="reg_field">
        <form action="" method="post">
            <div class="field">
                <label for="firstname">First Name(s)</label>
                <input type="text" name="firstname" id="firstname" value="<?php echo Input::get('firstname'); ?>" required pattern="(?=.*[a-zA-Z]).{2,}" title="min 2 chars and alphabets are a must">
            </div>
            <div class="field">
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" id="lastname" value="<?php echo Input::get('lastname'); ?>" required pattern="(?=.*[a-zA-Z]).{2,}" title="min 2 chars and alphabets are a must">
            </div>
            <div class="field">
                <label for="user_email">Email</label>
                <input type="email" name="user_email" id="user_email" value="<?php echo Input::get('user_email'); ?>" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Something like 'user@mail.domain'. Don't worry, you can do it">
            </div>
            <div class="field">
                <label for="user_name">Username</label>
                <input type="text" name="user_name" id="user_name" value="<?php echo Input::get('user_name'); ?>" autocomplete="off" required pattern="(?=.*[a-zA-Z]).{2,}" title="min 2 chars and alphabets are a must">
            </div>
            <div class="field">
                <label for="password">Create a Password</label>
                <input type="password" name="password" id="password" required pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}" title="min 8 characters lower and upper case atleast">
            </div>
            <div class="field">
                <label for="confirm_password">Confirm your Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}" title="must be the same as the above field">
            </div>
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"> <!-- this is the salt above -->
            <!-- no token generated. nevermind, i was directing the $_SESSION[config] to sessions wrong.--> 
            <input type="submit" value="Register">
            <div>
                <p err1 hidden> wrong password</p>
            </div>
        </form>
    </div>
    <footer class="footer">
    &copy; jphasha 2019
    </footer>
</body>
</html>