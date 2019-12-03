<?php
require '../core/initialise.php';

$gallery = new Gallery();
$user = new User();
$gallery->setPath('../uploads/');
$db = DB::getInstance();
$likes = $db->get('likes', array('like_id', '>', 0));
$like_count = $likes->count();
$images = $gallery->getImages();
$img_id = $gallery->getImageId();

if (!$user->isLoggedIn())
{
    $id_counter = 0;
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
        <p>
            <?php echo '<p>You need to <a href="login.php">Log in</a> or <a href="register.php">Register</a></p>'; ?>
        </p>
    </header>
    <div class="gal_con">
        <?php if($images): ?>
            <div class="gallery cf">
                <?php foreach($images as $image): ?>
                    <div class="gal_item">
                        <a href="<?php echo $image['full'] ?>"><img src="<?php echo $image['full']; ?>" class="pre_img" id="<?= $img_id[$id_counter] ?>">
                        <?php $id_counter = $id_counter + 1; ?>
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
<?php
}

else if ($user->isLoggedIn())
{
    $id_counter = 0;
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
        <a href="logout.php">Log out</a>
    </header>
    <div class="gal_con">
        <?php if($images): ?>
            <div class="gallery cf">
                <?php foreach($images as $image): ?>
                    <div class="gal_item">
                        <a href="<?php echo $image['full'] ?>"><img src="<?php echo $image['full']; ?>" class="pre_img"></a>
                        <div class="like_field">
                            <form action="like.php" method="post" name="like">
                                <input type="submit" value="like" name="like" id="<?= $img_id[$id_counter] ?>"/>
                            </form>
                            <p><?php echo $like_count . " likes"; ?></p>
                        </div>
                        <?php $id_counter = $id_counter + 1; ?>
                        <div class="comment_field">
                            <form action="comment.php" method="post">
                                <div>
                                    <textarea name="right" id="" cols="30" rows="10" value=""></textarea>
                                </div>
                                <div>
                                    <input type="submit" value="test" name="comment_btn" id="comment">
                                </div>
                            </form>
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
<?php
}
?>