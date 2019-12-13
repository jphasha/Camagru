<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../core/initialise.php';


if (isset($_GET['user']))
{
    $user = new User();
    $status = $user->find(Input::get('user'));
    
    if ($status)
    {
        $mail_salt = Input::get('salt');
        $db_salt = $user->data()->salt;
        $user_id = $user->data()->user_id;

        if ($db_salt == $mail_salt)
        {
            $user->update(['confirmed' => 1], $user_id);
        }
    }
}

if (Input::exists())
{
    if (Token::check(Input::get('token')))
    {
        $validate = new Validate();
        $validation = $validate->check(
            array(
                'username' => array(
                    'required' => true,
                    'valid_name' => 'alphabetic'),

                'password' => array(
                    'required' => true,
                    'min' => 8,
                    'max' => 50,
                    'strong_pattern' => 'lower and upper case')
            )
        );

        if ($validation->passed())
        {
            $user = new User();

            if (Input::get('remember') === 'on')
            {
                $remember = true;
            }
            else
            {
                $remember = false;
            }

            $login = $user->login(escape(Input::get('username')), escape(Input::get('password'), $remember));

            if ($login)
            {
                Redirect::to('../index.php');
            }
            else
            {
                echo "no can do jack";
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
    </header>
    <form action="" method="post">
        <div class="field">
            <label for="username">
                Username
            </label>
            <input type="text" name="username" id="username" autocomplete="off" required pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}" title="min 8 characters lower and upper case atleast">
        </div>

        <div class="field">
            <label for="password">
                Password
            </label>
            <input type="password" name="password" id="password" autocomplete="off" required pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}" title="min 8 characters lower and upper case atleast">
        </div>

        <br>

        <div class="field">
            <label for="remember">
                <input type="checkbox" name="remember" id="remember"> Remember me
            </label>
        </div>
        <br>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <input type="submit" value="Log in">
        <br><br>
        <a href="forgot_passwrd.php">Forgot Password?</a>
    </form>
    <footer class="footer">
    &copy; jphasha 2019
    </footer>
</body>
</html>