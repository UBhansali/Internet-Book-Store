<?php
require_once("../object/book.php");
require_once("../object/author.php");
require_once("../object/publisher.php");
require_once("../database.php");

$year = $_GET['year'];

try {
    $stmt = $conn->prepare("
        SELECT `book`.*, count(1) as `purchases` 
        FROM `book` 
        LEFT JOIN `purchase` on (`book`.`ISBN13` = `purchase`.`ISBN13`) 
        WHERE year = :year 
        GROUP BY `book`.`ISBN13`
        ORDER BY `purchases` DESC
        LIMIT 1
        ");
    $stmt->execute(array(':year' => $year));
    print json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    return -1;
}
?>