<?php
require '../core/initialise.php';

$gallery = new Gallery();
$user = new User();
$gallery->setPath('../uploads/');

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

        <button><a href="includes/view_gal.php">Gallery</a></button>
        <button><a href="includes/logout.php">Log out</a></button>
        <button><a href="includes/update.php">Update</a></button>
        <button><a href="includes/changepassword.php">change password</a></button>
        <button><a href="includes/upload.php">Upload a picture</a></button>
        <button><a href="includes/new_webcam.php">take a picture</a></button>

    </header>
    <div class="gal_con">
        <?php if($images): ?>
            <div class="gallery cf">
            
                <?php foreach($images as $image): ?>
                    <div class="gal_item">
                        <a href="<?php echo $image['full'] ?>"><img src="<?php echo $image['full']; ?>" class="pre_img" id=""></a>
                        <div class="comments">
                            <?php
                            $comment_cntr = 0;
                            $comment_count = count($gallery->getComments($img_id[$id_counter][$id_counter]));
                            try
                            {
                                while($comment_count > $comment_cntr)
                                {
                                    $comments_objByImg = $gallery->getComments($img_id[$id_counter][$id_counter])[$comment_cntr]->comment;
                                    echo $comments_objByImg . "<br>";
                                    $comment_cntr = $comment_cntr + 1;
                                }
                            }
                            catch (Exception $er)
                            {
                                echo $er;
                            }
                            ?>
                        </div>
                        <div class="like_field">
                            <form action="like.php" method="post" name="like">
                                <input type="hidden" name="img_id" value="<?php echo $img_id[$id_counter][$id_counter]; ?>">
                                <input type="submit"
                                        value="<?php if ($gallery->getLikes(Session::get('user'), $img_id[$id_counter][$id_counter]) === 0 )
                                                        echo 'like';
                                                    else
                                                        echo 'unlike';?>"
                                        name="like"/>
                            </form>
                            <p><?php echo $gallery->getLikesCount($img_id[$id_counter][$id_counter]) . " likes"; ?></p>
                        </div>
                        
                        <div class="comment_field">
                            <form action="comment.php" method="post">
                                <div>
                                    <textarea name="right" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div>
                                    <input type="hidden" name="img_id" value="<?php echo $img_id[$id_counter][$id_counter]; ?>">
                                    <input type="submit" value="comment" name="comment_btn" id="comment">
                                </div>
                            </form>
                        </div>
                        <?php $id_counter = $id_counter + 1; ?>
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