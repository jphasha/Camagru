<?php
    require_once "../core/initialise.php";
     session_start();
     ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
     

    function super_impose($img_src,$upload_dest,$sticker)
    {
        $superpose;
        $encrpt_img = imagecreatefrompng($img_src);
        $superposed_pic= imagecreatefrompng($sticker);
        list($width, $height) = getimagesize($img_src);
        list($width_small, $height_small) = getimagesize($sticker);
        imagecopyresampled($encrpt_img , $superposed_pic,  20, 20, 0, 0, 100, 100,$width_small, $height_small);
        imagepng($encrpt_img , $upload_dest);
    }

    if (isset($_POST['image_url']))
    {
        echo "<script>res.json({err: 'err'});</script>";
        $filteredData = str_replace("data:image/png;base64,", "", $_POST['image_url']);
        $filter = str_replace(" ", "+", $filteredData);
        $image = base64_decode($filter);
        $name = time().'.png';
        file_put_contents('../uploads/'.$name, $image);
        super_impose('../uploads/'.$name,'../uploads/'.$name,'../stickers/'.$_POST['sticker']);
        $userId = $_SESSION['user_id'];
        $imageName = $name;

        $pdo = DB::getInstance();
        $sql = $pdo->query("INSERT INTO pictures(`user_id`, `picture_name`) VALUES (?,?)", [$userId, $imageName]);
        if ($sql->count())
            echo "<script>console.log('success')</script>";
        else 
        {
            echo "<script>console.log('failure')</script>";
        }
    }

?>