<?php
require_once("../object/book.php");
require_once("../object/author.php");
require_once("../object/publisher.php");
require_once("../database.php");

$name = $_GET["auth_name"];

try {
    $stmt = $conn->prepare("SELECT * FROM book WHERE ISBN13 IN (SELECT ISBN13 FROM writes WHERE aid IN (SELECT aid FROM author WHERE name = :name))");
    $stmt->execute(array(':name' => $name));
    print json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    return -1;
}
?>