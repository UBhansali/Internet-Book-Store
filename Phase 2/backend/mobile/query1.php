<?php
require_once("../object/book.php");
require_once("../object/author.php");
require_once("../object/publisher.php");
require_once("../database.php");

try {
    $stmt = $conn->prepare("SELECT DISTINCT a.name FROM purchase p, author a, customer c WHERE c.cid = p.cid AND a.name = c.name");
    $stmt->execute();
    print json_encode($stmt->fetchAll());
} catch (Exception $e) {
    return -1;
}
?>