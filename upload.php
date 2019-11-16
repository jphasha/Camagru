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
    <form action="classes/Upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="photo">
        <input type="submit" value="upload" name="upload">
    </form>
</body>
</html>