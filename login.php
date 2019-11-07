<?php
require_once 'core/initialise.php';

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
        <label for="username">
            Username
        </label>
        <input type="text" name="username" id="username" autocomplete="off">

        <br>

        <label for="password">
            Password
        </label>
        <input type="password" name="password" id="password" autocomplete="off">

        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <input type="submit" value="Log in">
    </div>
</form>