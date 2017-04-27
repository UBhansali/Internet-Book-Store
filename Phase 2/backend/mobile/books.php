<?php
require_once("../object/book.php");
require_once("../object/author.php");
require_once("../object/publisher.php");
require_once("../database.php");

try {
    $stmt = $conn->prepare("SELECT b.ISBN13, b.title, b.price, GROUP_CONCAT(a.name SEPARATOR ', ') as author_list FROM book b, author a, writes w WHERE w.ISBN13 = b.ISBN13 AND a.aid = w.aid GROUP BY b.ISBN13");
    $stmt->execute();
    print json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    return -1;
}
?>