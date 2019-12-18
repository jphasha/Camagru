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
                    'user_name' => Input::get('user_name'),
                    'user_email' => Input::get('user_email')
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

        <button><a href="view_gal.php">Gallery</a></button>
        <button><a href="logout.php">Log out</a></button>
        <button><a href="update.php">Update</a></button>
        <button><a href="changepassword.php">change password</a></button>
        <button><a href="upload.php">Upload a picture</a></button>
        <button><a href="new_webcam.php">take a picture</a></button>

    </header>
    <div class="upd_field">
        <form action="" method="post">
            <div class="field">
                <label for="user_name">User Name</label>
                <input type="text" name="user_name" value="<?php echo escape($user->data()->user_name); ?>">

                <!-- <label for="user_pass">Password</label> -->
                <!-- <input type="text" name="user_pass" value="?php echo escape($user->data()->user_pass); ?>"> -->

                <label for="user_email">email</label>
                <input type="text" name="user_email" value="<?php echo escape($user->data()->user_email); ?>" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Something like 'user@mail.domain'. Don't worry, you can do it">

                <input type="submit" value="Update">
                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" required pattern="(?=.*[a-zA-Z]).{2,}" title="min 2 chars and alphabets are a must">
            </div>
        </form>
    </div>
    <footer class="footer">
    &copy; jphasha 2019
    </footer>
</body>
</html>