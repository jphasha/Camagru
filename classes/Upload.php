<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../core/initialise.php';

$gallery = new Gallery();
// if the upload button is pressed.
if (isset($_POST['upload']))
{
    // in our super variable '$_FILES', give me data with the name 'photo'.
    $photo = $_FILES['photo'];

    // photo properties
    $photo_name = $photo['name'];
    $photo_tmp = $photo['tmp_name'];
    $photo_size = $photo['size'];
    $photo_error = $photo['error'];

    // set file extensions
    $photo_ext = explode('.', $photo_name);
    $photo_ext = strtolower(end($photo_ext));

    // allowed stuff
    $allowed = array('txt', 'jpg', 'png', 'jpeg');

    if (in_array($photo_ext, $allowed)) // check if "$file_ext" is in "$allowed" array.
    {
        if ($photo_error === 0)
        {
            if ($photo_size <= 10000000)
            {
                $photo_name_new = uniqid('', true) . '.' . $photo_ext;
                $photo_destination = '../uploads/' . $photo_name_new;

                if (!file_exists('../uploads'))
                    mkdir('../uploads');

                if (move_uploaded_file($photo_tmp, $photo_destination))
                {
                    $gallery->insertImage(Session::get('user'), $photo_name_new);
                }
                else
                {
                    echo "could not move photo to destination <br>";
                }
            }
            else
            {
                echo "photo too big <br>";
            }
        }
        else
        {
            echo "there are some errors with your photo.<br>";
        }
    } 
    else
    {
        echo "file type not allowed <br>";
    }
}


if (isset($_POST['image_saver']))
{
    $encd_data = Input::get('image_encrypt');
    $filtered_data = str_replace("data:image/png;base64,", "", $encd_data); //remove the "data:image/png;base64," at the beginning of the encrypted data string. this will allow decryption.
    $decrpt_image_data = base64_decode($filtered_data); // ofcourse we decode.
    $pic_name = uniqid('', true) . '.png'; // unique id so that there won't be any images with the same name which may end up being overwritten by function file_put_contents() below.
    $upload_dest = '../uploads';

    if (!file_exists($upload_dest)) // no need to mkdir everytime we start afresh.
    {
        mkdir($upload_dest);
    }

    if (file_put_contents($upload_dest . '/' . $pic_name, $decrpt_image_data))
    {
        $gallery->insertImage(Session::get('user'), $pic_name);
    }
}

else
{
    echo "nah<br>";
}

Redirect::to('../includes/view_gal.php');
?>