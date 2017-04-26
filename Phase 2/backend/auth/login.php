<?php
require("../object/jwt.php");
define("SECRET", "jsfj23jh");
$conn = new PDO('mysql:host=127.0.0.1;dbname=bookdb;charset=utf8;', 'root', 'pass');

$email = $_POST['email'];
$password = trim($_POST['password']);

try {
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = :email");
    $stmt->execute(array(':email' => $email));

    if (strcmp($stmt->fetch()["password"], $password) === 0)
    {
        $pl = array();
        $pl["id"] = $stmt->fetch()["id"];
        $pl["email"] = $email;
        $jwt = encode(SECRET, $pl);

        print "{\"auth\": true, \"token\": \"$jwt\"}";
    }
    else
    {
        print "false";
    }
} catch (Exception $e) {
    return -1;
}

?>