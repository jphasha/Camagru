<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../core/initialise.php';

$test = DB::getInstance();
$imageId = Input::get('img_id');
$notificationStatus = $test->notificationStatus($imageId);

if (isset($_POST['comment_btn']))
{
    $test->insert('comments', [
        'picture_id' => $imageId,
        // 'user_id' => 1,
        'commentor_id' => Session::get('user'),
        // 'comment' => escape($_POST['right']) //filter_var($_POST['right'], FILTER_SANITIZE_STRING)
        'comment' => Input::get('right')
    ]);

    if ($notificationStatus)
    {
        $ownerEmail = $test->ownerEmail($imageId);
        $subject = "Picture comment";
        $message = "Someone has commented on your picture on your camagru account";
        $headers = 'From:noreply@themail.com' . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type:text/html;charset=UTF-8" . "\r\n";

        mail($ownerEmail, $subject, $message, $headers);
    }
}

Redirect::to('view_gal.php');
?>