<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../core/initialise.php';

$user = new User();

if ($user->isLoggedIn())
{
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="logout.php">Log out</a>
    <form action="../classes/Upload.php" method="post" enctype="multipart/form-data">
    <div>
        <input type="file" name="photo">
    </div>
    <div>
        <input type="submit" value="upload" name="upload">
    </div>
    </form>
</body>
</html>
<?php
}

else
{
    Redirect::to('../index.php');
}
?>