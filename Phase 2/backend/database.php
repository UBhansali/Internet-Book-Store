<?php
$host = "127.0.0.1";
$dbname = "bookdb";
$user = "root";
$pass = "pass";
$charset = "utf8";

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset;", $user, $pass);
?>