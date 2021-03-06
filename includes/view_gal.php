<?php
require '../core/initialise.php';

$gallery = new Gallery();
$user = new User();
$gallery->setPath('../uploads/');

            if (!isset($_GET['page']))
            {
                $page = 1;
            }

            else
            {
                $page = $_GET['page'];
            }
// $img_id = $gallery->getImageId();
$total_images = $gallery->getImageCount();
$images_per_page = 5;
$number_of_pages = ceil($total_images/$images_per_page);
$starting_point = ($page - 1) * $images_per_page;
$images = $gallery->getPaginatedImages($starting_point, $images_per_page);

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
                        <a href="<?php echo $image['full'] ?>"><img src="<?php echo $image['full']; ?>" class="pre_img" id="<?= $gallery->paginatedPicId($image); ?>"></a>
                        <div class="like_field">
                            <p><?php echo $gallery->getLikesCount($gallery->paginatedPicId($image)) . " likes"; ?></p>
                        </div>
                        <div class="comments">
                            <?php
                            $comment_cntr = 0;
                            $comment_count = count($gallery->getComments($gallery->paginatedPicId($image)));
                            try
                            {
                                while($comment_count > $comment_cntr)
                                {
                                    $comments_objByImg = $gallery->getComments($gallery->paginatedPicId($image))[$comment_cntr]->comment;
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
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            There are no images.
        <?php   endif;
                for ($page = 1; $page <= $number_of_pages; $page++)
                {
                    echo '<a href="view_gal.php?page=' . $page . '">' . $page . '</a> ';
                }
        ?>
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

        <button><a href="../index.php">Home</a></button>
        <button><a href="view_gal.php">Gallery</a></button>
        <button><a href="logout.php">Log out</a></button>
        <button><a href="update.php">Update</a></button>
        <button><a href="changepassword.php">change password</a></button>
        <button><a href="upload.php">Upload a picture</a></button>
        <button><a href="new_webcam.php">take a picture</a></button>

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
                            $comment_count = count($gallery->getComments($gallery->paginatedPicId($image)));
                            try
                            {
                                while($comment_count > $comment_cntr)
                                {
                                    $comments_objByImg = $gallery->getComments($gallery->paginatedPicId($image))[$comment_cntr]->comment;
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
                                <input type="hidden" name="img_id" value="<?php echo $gallery->paginatedPicId($image); ?>">
                                <input type="submit"
                                        value="<?php if ($gallery->getLikes(Session::get('user'), $gallery->paginatedPicId($image)) === 0 )
                                                        echo 'like';
                                                    else
                                                        echo 'unlike';?>"
                                        name="like"/>
                            </form>
                            <p><?php echo $gallery->getLikesCount($gallery->paginatedPicId($image)) . " likes"; ?></p>
                        </div>
                        
                        <div class="comment_field">
                            <form action="comment.php" method="post">
                                <div>
                                    <textarea name="right" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div>
                                    <input type="hidden" name="img_id" value="<?php echo $gallery->paginatedPicId($image); ?>">
                                    <input type="submit" value="comment" name="comment_btn" id="comment">
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            There are no images.
        <?php   endif;
                for ($page = 1; $page <= $number_of_pages; $page++)
                {
                    echo '<a href="view_gal.php?page=' . $page . '">' . $page . '</a> ';
                }
        ?>
    </div>
    <footer class="footer">
    &copy; jphasha 2019
    </footer>
</body>
</html>
<?php
}
?>