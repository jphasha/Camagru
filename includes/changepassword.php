<?php

require_once '../core/initialise.php';

$user = new User();
$db = DB::getInstance();

if (!$user->isLoggedIn())
{
?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Change Password</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
            <header class="header">

                <button><a href="../index.php">Home</a></button>
                <button><a href="view_gal.php">Gallery</a></button>
                <button><a href="logout.php">Log out</a></button>
                <button><a href="update.php">Update</a></button>
                <button><a href="changepassword.php">change password</a></button>
                <button><a href="upload.php">Upload a picture</a></button>
                <button><a href="new_webcam.php">take a picture</a></button>

            </header>

            <form action="" method="post">
                <div class="field">
                    <label for="new_password">new password</label>
                    <input type="password" name="new_password2" id="new_password2" required pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}" title="min 8 characters lower and upper case atleast">
                </div>

                <div class="field">
                    <label for="confirm_new_password">confirm new password</label>
                    <input type="password" name="confirm_new_password2" id="confirm_new_password2" required pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}" title="min 8 characters lower and upper case atleast">
                </div>

                <input type="submit" name="submit" value="change"/>
            </form>
        </body>
        <footer class="footer">
            &copy; jphasha 2019
        </footer>
    </html>

<?php

    if (Input::exists())
    {
        if (isset($_GET['salt']) && $_GET['salt'] !== 'false')
        {
            $salt_check = $db->get('users', ['salt', '=', escape($_GET['salt'])])->results();
            if ($salt_check)
            {
                $validate = new Validate();
                $validation = $validate->check($_POST, array(
                    'new_password2' => array(
                        'required' => true,
                        'min' => 8,
                        'strong_pattern' => 'lower and upper case'
                    ),
                    'confirm_new_password2' => array(
                        'required' => true,
                        'min' => 8,
                        'strong_pattern' => 'lower and upper case',
                        'matches' => 'new_password2'
                    )
                    )
                );
                if ($validation->passed())
                {

                    $it_id = $salt_check[0]->user_id;

                    $db->update('users', $it_id, [
                        'user_pass' => password_hash(Input::get('new_password2'), PASSWORD_DEFAULT)
                    ]);
                }
            }
            
            Session::flash('change password', 'please go to your email and click on the reset password link');
        }

        Redirect::to('../index.php');
    }
}
?>

            
<?php
if ($user->isLoggedIn())
{
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Change password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">

        <button><a href="../index.php">Home</a></button>
        <button><a href="view_gal.php">Gallery</a></button>
        <button><a href="logout.php">Log out</a></button>
        <button><a href="update.php">Update</a></button>
        <button><a href="changepassword.php">change password</a></button>
        <button><a href="upload.php">Upload a picture</a></button>
        <button><a href="new_webcam.php">take a picture</a></button>

    </header>
    <div class="cng_field">
        <form action="" method="post">
            <div class="field">
                <label for="current_password">current password</label>
                <input type="password" name="current_password" id="current_password" required pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}" title="min 8 characters lower and upper case atleast">
            </div>

            <div class="field">
                <label for="new_password">new password</label>
                <input type="password" name="new_password" id="new_password" required pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}" title="min 8 characters lower and upper case atleast">
            </div>
            <div class="field">
                <label for="confirm_new_password">confirm new password</label>
                <input type="password" name="confirm_new_password" id="confirm_new_password" required pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}" title="min 8 characters lower and upper case atleast">
            </div>

            <input type="submit" name="submit" value="change"/>
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        </form>
    </div>
    <footer class="footer">
    &copy; jphasha 2019
    </footer>
</body>
</html>

<?php
    if (Input::exists())
    {
        if (Token::check(Input::get('token')))
        {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'current_password' => array(
                    'required' => true,
                    'min' => 8,
                    'strong_pattern' => 'lower and upper case'
                ),
                'new_password' => array(
                    'required' => true,
                    'min' => 8,
                    'strong_pattern' => 'lower and upper case'
                ),
                'confirm_new_password' => array(
                    'required' => true,
                    'min' => 8,
                    'strong_pattern' => 'lower and upper case',
                    'matches' => 'new_password'
                )
                )
            );

            if ($validation->passed())
            {
                if (!password_verify(Input::get('current_password'), $user->data()->user_pass))
                {
                    echo "your current password is wrong.<br>";
                }
                else
                {
                    $user->update(array(
                    'user_pass' => password_hash(Input::get('new_password'), PASSWORD_DEFAULT)
                    )
                );

                Session::flash('home', 'password changed');

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
        Redirect::to('../index.php');
    }
}
?>