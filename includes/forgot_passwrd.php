<?php
require_once '../core/initialise.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password</title>
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
    <div class="contain">
        <form action="../server_side/reset_password.php" method="post">
        
            <input type="email" name="email" placeholder="PLEASE ENTER YOUR REGISTERED EMAIL" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Something like 'user@mail.domain'. Don't worry, you can do it">
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
            <br>
            <input type="submit" value="submit" name="reset">
            
        </form>
    </div>
    <footer class="footer">
    &copy; jphasha 2019
    </footer>
</body>
</html>