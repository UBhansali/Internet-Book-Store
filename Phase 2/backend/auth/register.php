<?php
require("../object/jwt.php");
define("SECRET", "jsfj23jh");
$conn = new PDO('mysql:host=127.0.0.1;dbname=bookdb;charset=utf8;', 'root', 'pass');

$email = $_POST['email'];
$password = trim($_POST['password']);

try {
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute(array(':email' => $email));

    if (count($stmt->fetchAll()) > 0)
    {
        print "{\"auth\": false, \"error\": \"register_user_exists\"}";
    }
    else
    {
        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (:email, :pass)");
        $stmt->execute(array(':email' => $email, ':pass' => $password));
        $id = $conn->lastInsertId();
        
        $pl = array();
        $pl["id"] = $id;
        $pl["email"] = $email;
        $jwt = encode(SECRET, $pl);

        print "{\"auth\": true, \"token\": \"$jwt\"}";
    }
} catch (Exception $e) {
    return -1;
}

?>