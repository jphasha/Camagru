<?php
require '../core/initialise.php';

$gallery = new Gallery();
$user = new User();
$gallery->setPath('../uploads/');
$db = DB::getInstance();
$likes = $db->get('likes', array('like_id', '>', 0));
$like_count = $likes->count();

$images = $gallery->getImages(); 

if (!$user->isLoggedIn())
{
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
                        <a href="<?php echo $image['full'] ?>"><img src="<?php echo $image['full']; ?>" class="pre_img">
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
    <a href="logout.php">Log out</a>
    <div class="gal_con">
        <?php if($images): ?>
            <div class="gallery cf">
                <?php foreach($images as $image): ?>
                    <div class="gal_item">
                        <a href="<?php echo $image['full'] ?>"><img src="<?php echo $image['full']; ?>" class="pre_img">
                        <div class="like_field">
                            <form action="like.php" method="post">
                                <input type="submit" value="like" name="like" id="like"/>
                            </form>
                            <p><?php echo $like_count . " likes"; ?></p>
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
<?php
}
?>