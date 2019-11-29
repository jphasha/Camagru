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
    <form action="classes/Upload.php" method="post" enctype="multipart/form-data">
    <div>
        <input type="file" name="photo">
    </div>
    <div>
        <input type="submit" value="upload" name="upload">
    </div>
    </form>
</body>
</html>