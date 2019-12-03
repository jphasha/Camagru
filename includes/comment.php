<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../core/initialise.php';

if (isset($_POST['comment_btn']))
{
    echo "commented<br>";
}
echo '<pre>';
var_dump($_POST);
echo '</pre>';

die('okay');
?>