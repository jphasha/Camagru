<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../core/initialise.php';


if (isset($_GET['user']))
{
    var_dump($_GET);
    die('<br><br>well?<br><br>');
}

if (Input::exists())
{
    if (Token::check(Input::get('token')))
    {
        $validate = new Validate();
        $validation = $validate->check(
            array(
                'username' => array('required' => true),
                'password' => array('required' => true)
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
                echo "no can do jack<br>just kidding, your password is wrong chief<br>wanna try again?";
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
            <input type="text" name="username" id="username" autocomplete="off">
        </div>

        <div class="field">
            <label for="password">
                Password
            </label>
            <input type="password" name="password" id="password" autocomplete="off">
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