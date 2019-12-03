<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'database.php';

$pdo = new PDO("mysql:host=$HOST;charset=utf8", $DB_USER, $DB_PASSWORD);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'CREATE DATABASE IF NOT EXISTS ' . $DB .' CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$sql = 'USE ' . $DB;
$stmt = $pdo->prepare($sql);
$stmt->execute();
$sql = "CREATE TABLE IF NOT EXISTS users (
	user_id INT AUTO_INCREMENT PRIMARY KEY,
	user_name VARCHAR(100) NOT NULL,
    user_pass VARCHAR(1000) NOT NULL,
	user_email VARCHAR(100) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
	`group` INT NOT NULL,
	salt VARCHAR(350) NOT NULL,
	confirmed TINYINT DEFAULT 0,
	notify	TINYINT DEFAULT 0,
	joined DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci";
$stmt = $pdo->prepare($sql);
$stmt->execute();
// $sql = "SELECT count(*) FROM `users` WHERE BINARY user_name = 'Admin'";
// $stmt = $pdo->prepare($sql);
// $stmt->execute();
// $number_of_rows = $stmt->fetchColumn();
// if(!$number_of_rows) {
// 	$sql = 'INSERT INTO users(`user_name`, `user_email`, `group`, `confirmed`, `notify`, `user_pass`, `salt`)
// 	VALUES ("Admin", "", 2, 1, 1, "' . $hash . '", "' . $s_hash . '")';
// 	$stmt = $pdo->prepare($sql);
// 	$stmt->execute();
// }
$sql = 'CREATE TABLE IF NOT EXISTS `groups` (
	group_id INT AUTO_INCREMENT PRIMARY KEY,
	user_id INT NOT NULL,
	group_name VARCHAR(50) NOT NULL,
	permissions TEXT) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$sql = "SELECT count(*) FROM `groups` WHERE group_name = 'Standard user'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$number_of_rows = $stmt->fetchColumn();
if(!$number_of_rows) {
	$sql = 'INSERT INTO `groups`(`group_name`) VALUES ("Standard user")';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
}
$sql = "SELECT count(*) FROM `groups` WHERE group_name = 'Administrator'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$number_of_rows = $stmt->fetchColumn();
if(!$number_of_rows) {
	$sql = 'INSERT INTO `groups`(`group_name`, `permissions`) VALUES ("Administrator", \'{\r\n\"admin\": 1,\r\n\"mod\": 1\r\n}\')';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
}
$sql = 'CREATE TABLE IF NOT EXISTS user_session (
	session_id INT AUTO_INCREMENT PRIMARY KEY,
	user_id INT NOT NULL,
	hash VARCHAR(64) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$sql = 'CREATE TABLE IF NOT EXISTS pictures (
	picture_id INT AUTO_INCREMENT PRIMARY KEY,
	user_id INT NOT NULL,
	picture_name VARCHAR(100) NOT NULL,
	upload_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$sql = 'CREATE TABLE IF NOT EXISTS comments (
	comment_id INT AUTO_INCREMENT PRIMARY KEY,
	picture_id INT NOT NULL,
	user_id INT NOT NULL,
	commentor_id INT NOT NULL,
	comment LONGBLOB NOT NULL,
	creation_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$sql = 'CREATE TABLE IF NOT EXISTS likes (
	like_id INT AUTO_INCREMENT PRIMARY KEY,
	picture_id INT NOT NULL,
	user_id INT NOT NULL,
	liker_id INT NOT NULL,
	creation_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci';
$stmt = $pdo->prepare($sql);
$stmt->execute();
?>