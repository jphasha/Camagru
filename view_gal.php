<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Camagru</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="gal_con">
        <div class="gallery cf">
            <?php for($x = 1; $x <= 2; $x++): ?>
                <div class="gal_item">
                    <img src="voda.jpeg" class="pre_img" style="height: 45px; width: 45px">
                </div>
            <?php endfor; ?>
        </div>
    </div>
</body>
</html>