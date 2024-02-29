<?php

session_start();
require "connection.php";

$sender = $_SESSION["u"]["email"];
$receiver = $_POST["e"];
$msg = $_POST["t"];

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d H:i:s");

Database::iud("INSERT INTO `chat`(`content`,`date_time`,`status`,`from`,`to`)VALUES
('".$msg."','".$date."','0','".$sender."','".$receiver."')");

echo("success");

?>