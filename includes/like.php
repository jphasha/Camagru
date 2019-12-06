<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../core/initialise.php';

$db = DB::getInstance();
$lik_tab = $db->get('likes', ['picture_id', '>', 0])->results()[0]->liker_id;

// if (isset($_GET['type'], $_GET['id']))
// {
//     $type = $_GET['type'];
//     $id = (int)$_GET['id']; // an id is always a number, so we cast it to an int.

//     switch($type)
//     {
//         case 'file':
//             $db->query(
//             "INSERT INTO likes (picture_id, liker_id) /* insert picture_id and user_id into likes table */ 
//             SELECT {$id}, {$_SESSION['user_id']}
//             FROM pictures
//             WHERE EXISTS /* the picture must exist in the pictures table and have the same id as the one being liked */
//             (
//                 SELECT picture_id
//                 FROM pictures
//                 WHERE picture_id = {$id}
//             )
//             AND NOT EXISTS /* however, data of this pic the user, must not already be in the likes table together. */
//             (
//                 SELECT like_id
//                 FROM likes
//                 WHERE user = {$_SESSION['user_id']}
//                 AND picture = {$id}
//             )
//             LIMIT 1    
//             ");
//         break;
//     }
// }

if (isset($_POST['like']))
{
    // $liked = 1;
    // if($_POST['liker_id'] == $lik_tab)
    // {
    //     echo "alright<br>";
    // }
    // echo $_POST['liker_id'] . "<br>";
    // echo $lik_tab . "<br>";
    // die('whar');
    if (!$_POST['liker_id'] == $lik_tab)
    {
        $db->insert('likes', array(
            'picture_id' => $_POST['img_id'],
            'liker_id' => Session::get('user')
        ));
    }
}

Redirect::to('view_gal.php');
?>