<?php
require '../core/initialise.php';

$gallery = new Gallery();
$gallery->setPath('../uploads/');

$images = $gallery->getImages(array('png')); // it is possible that i don't quite this getImages function because it is misbehaving.

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
    <header class="header">
    </header>
    <div class="gal_con">
        <?php if($images): ?>
            <div class="gallery cf">
                <?php foreach($images as $image): ?>
                    <div class="gal_item">
                        <a href="<?php echo $image['full'] ?>"><img src="<?php echo $image['full']; ?>" class="pre_img">
                        <div class="like_field">
                            <a href="">Like</a>
                            <p>3</p>
                        </div>
                        <div class="comment_field">
                            <a href="">Comment</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            There are no images.
        <?php endif; ?>
    </div>
    <footer class="footer">
    &copy; jphasha 2019
    </footer>
</body>
</html>