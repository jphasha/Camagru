<?php
require_once 'core/initialise.php';

if (Input::exists())
{
    // echo Input::get('username'); // not echoing this variable even though it is suppossed to.
    $validate = new Validate()
}
?>

<form action="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="" autocomplete="off">
    </div>
    <div class="field">
        <label for="email">Email</label>
        <input type="text" name="email" id="email">
    </div>
    <div class="field">
        <label for="password">Create a password</label>
        <input type="text" name="password" id="password">
    </div>
    <div class="field">
        <label for="Confirm Password">Confirm your Password</label>
        <input type="text" name="username" id="username">
    </div>
    <input type="submit" value="Register">
</form>