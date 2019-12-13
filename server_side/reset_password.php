<?php

require_once '../core/initialise.php';

if (isset($_POST['reset']))
{
    $db = DB::getInstance();
    $email = Input::get('email');
    $salt = Input::get('token');
    $email_exist = $db->emailExists($email);
    if ($email_exist)
    {
        $subject = "Password Reset";
        $message = "You requested a password reset. If this is not you, just ignore this email.";
        $message .= "\r\n";
        $message .= "Otherwise please click on the following link to complete password reset:";
        $message .= "\r\n";
        $message .= "<a href='http://localhost:8080/projects_github/github_camagru/includes/login.php?&salt=$salt'>Reset Password</a>";
        $headers = 'From:noreply@themail.com' . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type:text/html;charset=UTF-8". "\r\n";

        Redirect::to('../includes/changepassword.php');
    }
    else
    {
        Redirect::to('../index.php');
    }
}
?>