<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
            'user_name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            )
            )
        );

        if ($validation->passed())
        {
            try
            {
                $user->update(array(
                    'user_name' => Input::get('user_name')
                )
            );

            Session::flash('home', 'updated');

            Redirect::to('../index.php');
            }
            catch(Exception $someException)
            {
                die($someException->getMessage());
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
    </header>
    <a href="logout.php">Log out</a>
    <div class="upd_field">
        <form action="" method="post">
            <div class="field">
                <label for="user_name">User Name</label>
                <input type="text" name="user_name" value="<?php echo escape($user->data()->user_name); ?>">

                <input type="submit" value="Update">
                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
            </div>
        </form>
    </div>
    <footer class="footer">
    &copy; jphasha 2019
    </footer>
</body>
</html>