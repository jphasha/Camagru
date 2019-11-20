<?php
if (isset($_POST['upload']))
{
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

                if (move_uploaded_file($photo_tmp, $photo_destination))
                {
                    echo $photo_destination;
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
    } 
    else
    {
        echo "file type not allowed <br>";
    }
}
else
{
    echo "nah";
}
?>