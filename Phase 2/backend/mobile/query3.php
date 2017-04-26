<?php
require_once("../object/book.php");
require_once("../object/author.php");
require_once("../object/publisher.php");
require_once("../database.php");

$name = $_POST["auth_name"];

try {
    $stmt = $conn->prepare("SELECT * FROM book b, purchase p WHERE p.cid = (SELECT cid FROM customer WHERE name = :name) AND p.ISBN13 = b.ISBN13");
	$stmt->execute(array(':name' => $name));
    print json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    return -1;
}

?>