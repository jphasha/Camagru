<?php
    // require_once "config/database.php";
     session_start();
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
         $filteredData = str_replace("data:image/png;base64,", "", $_POST['image_url']);
         $filter = str_replace(" ", "+", $filteredData);
         $image = base64_decode($filter);
         $name = time().'.png';
         file_put_contents('../uploads/'.$name, $image);
         super_impose('../uploads/'.$name,'../uploads/'.$name,'../stickers/'.$_POST['sticker']);
      /*   $out = 'uploads/'.$name;
         $sql = $conn->prepare("INSERT INTO `camagru`.`images` (`img_name`, `img_dir`)
         VALUES (:img_name,:img_dir)");
         $sql->bindValue(':img_name',$name);
         $sql->bindValue(':img_dir',$out);
         $sql->execute();
         if ($sql->rowCount())
             echo "success";*/
     }
     else 
     {
         echo "failed";
     }

?>