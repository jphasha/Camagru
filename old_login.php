<?php
require_once 'core/initialise.php';

if (Input::exists())
{
    echo Input::exists('user_name');
}
else
{
    echo "pooih";
}
?>

<html>
    <head>
        <title>
        login page
        </title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <header class="top_bar">
            Camagru
            <form class="log_in_field" name="login" method="post">
                <input type="text" placeholder="Username" name="user_name"> Username
                <input type="text" placeholder="Password" name="password"> Password
                <input type="button" value="log_in">
            </form>
        </header>
        <section>
			<p class="sign_up_con">
                sign up
            </p>
            <form class="sign_up_field" name="sign_up" method="post">
                <input type="text" placeholder="First Name(s)">First Name<br>
                <input type="text" placeholder="Last Name">Last Name<br>
                <input type="text" placeholder="Username">Username<br>
                <input type="text" placeholder="Email">Email<br>
                <input type="text" placeholder="Create Password">Create Password<br>
                <input type="text" placeholder="Confirm Password">Confirm Password<br>
                <input type="button" value="sign_up">
            </form>
        </section>
        <footer class="bottom_bar">
            &copy; all rights reserved 2019
        </footer>
    </body>
</html>
