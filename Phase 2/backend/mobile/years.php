<?php
require_once("../object/book.php");
require_once("../object/author.php");
require_once("../object/publisher.php");
require_once("../database.php");

try {
    $stmt = $conn->prepare("SELECT distinct(b.year) FROM book b ORDER by b.year ASC");
    $stmt->execute();
    print json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    return -1;
}
?>