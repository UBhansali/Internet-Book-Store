<?php
require_once("object/book.php");
require_once("object/author.php");
require_once("object/publisher.php");
require_once("database.php");
session_start();
$conn = new PDO('mysql:host=127.0.0.1;dbname=bookdb;charset=utf8;', 'root', 'pass');
$type = $_POST['type'];

switch ($type) {
	case 'select': $_SESSION['ans_num'] = $_POST['part_select']; break;
	case 'part1': $_SESSION['ans'] = doPartOne($conn); $_SESSION['ans_num'] = "part1"; break;
	case 'part2': $_SESSION['ans'] = doPartTwo($conn, $_POST['auth_name']); $_SESSION['ans_num'] = "part2"; break;
	case 'part3': $_SESSION['ans'] = doPartThree($conn, $_POST['cust_name']); $_SESSION['ans_num'] = "part3"; $_SESSION['cust_name'] = $_POST['cust_name']; break;
	case 'part4': $_SESSION['ans'] = doPartFour($conn, $_POST['keywords']); $_SESSION['ans_num'] = "part4"; break;
	case 'part5': $_SESSION['ans'] = doPartFive($conn, $_POST['year']); $_SESSION['year'] = $_POST['year']; $_SESSION['ans_num'] = "part5"; break;
	case 'part6': doPartSix($conn, $_POST['ISBN13'], $_POST['cid']); $_SESSION['ans_num'] = "part6"; break;
	case 'part7': doPartSeven($conn, $_POST['name'], $_POST['address'], $_POST['ssn'], $_POST['telephone'], $_POST['email']); $_SESSION['ans_num'] = "part7"; break;
	case 'part8': doPartEigth($conn, $_POST['ssn'], $_POST['address']); $_SESSION['ans_num'] = "part8"; break;
	case 'part9': doPartNine($conn, $_POST); $_SESSION['ans_num'] = "part9"; break;		
	case 'part10': doPartTen($conn, $_POST['ISBN13']); $_SESSION['ans_num'] = "part10"; break;
	default: $_SESSION['ans_num'] = "part1"; break;
}

function deleteBook($conn, $ISBN) {
	try {
		$stmt = $conn->prepare("DELETE FROM books WHERE ISBN13 = :ISBN");
		$stmt->execute(array(':ISBN' => $ISBN));
		return 1;
	} catch (Exception $e) {
		return -1;
	}
}

function doPartOne($conn) {
	try {
		$stmt = $conn->prepare("SELECT DISTINCT a.name FROM purchase p, author a, customer c WHERE c.cid = p.cid AND a.name = c.name");
		$stmt->execute();
		return $stmt->fetchAll();
	} catch (Exception $e) {
		return -1;
	}
}

function doPartTwo($conn, $name) {
	try {
		$stmt = $conn->prepare("SELECT * FROM book WHERE ISBN13 IN (SELECT ISBN13 FROM writes WHERE aid IN (SELECT aid FROM author WHERE name = :name))");
		$stmt->execute(array(':name' => $name));
		return $stmt->fetchAll();
	} catch (Exception $e) {
		return -1;
	}
}

function doPartThree($conn, $name) {
	try {
		$stmt = $conn->prepare("SELECT * FROM book b, purchase p WHERE p.cid = (SELECT cid FROM customer WHERE name = :name) AND p.ISBN13 = b.ISBN13");
		$stmt->execute(array(':name' => $name));
		return $stmt->fetchAll();
	} catch (Exception $e) {
		return -1;
	}
}

function doPartFour($conn, $keyword) {
	try {
		$stmt = $conn->prepare('SELECT b.ISBN13, b.title, b.year, b.category, b.price, GROUP_CONCAT(a.name, ";|;", a.address, ";|;", a.ssn SEPARATOR "#|#") as author_list, p.pname, p.city, p.state FROM book b, author a, publisher p, writes w WHERE b.title LIKE :keyword AND w.ISBN13 = b.ISBN13 AND a.aid = w.aid AND b.pname = p.pname GROUP BY b.ISBN13');
		$stmt->execute(array(':keyword' => "%".$keyword."%"));
		$results = $stmt->fetchAll();

		$books = [];

		foreach ($results as $row) {
			$author_list = explode("#|#", $row['author_list']);
			$authors = [];
			foreach ($author_list as $a) {
				$author_info = explode(";|;", $a);
				$authors[] = new Author($author_info[0], $author_info[1], $author_info[2]);
			}
			$publisher = new Publisher($row["pname"], $row["city"], $row["state"]);
			$books[] = new Book($row["ISBN13"], $row["title"], $row["year"], $row["category"], $row["price"], $authors, $publisher);
		}
		return $books;
	} catch (Exception $e) {
		return -1;
	}
}

function doPartFive($conn, $year) {
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
		return $stmt->fetchAll();
	} catch (Exception $e) {
		return -1;
	}
}
function doPartSix($conn, $ISBN13, $cid) {
	try {
		$now = time();
		$stmt = $conn->prepare("INSERT INTO `purchase`(`ISBN13`, `cid`, `datetime`) VALUES (?,?,?)");
		$stmt->execute(array($ISBN13, $cid, $now));
	} catch (Exception $e) {
		return -1;
	}
}
function doPartSeven($conn, $name, $address, $ssn, $telephone, $email) {
	try {
		$conn->beginTransaction();
		
		$stmt = $conn->prepare("INSERT INTO `people`(`name`, `address`, `ssn`, `telephone`, `email`)  VALUES (?,?,?,?,?)");
		$stmt->execute(array($name, $address, $ssn, $telephone, $email));
		$stmt = $conn->prepare("INSERT INTO `customer`(`name`, `address`, `ssn`)  VALUES (?,?,?)");
		$stmt->execute(array($name, $address, $ssn));
		
		$conn->commit();
	} catch (Exception $e) {
		$conn->rollBack();
		return -1;
	}
}
function doPartEigth($conn, $ssn, $address) {
	try {
		$conn->beginTransaction();
		
		$stmt = $conn->prepare("SET FOREIGN_KEY_CHECKS=0;");
		$stmt->execute();
		//check if that name exists in customers table. If it does, then update that
		$stmt = $conn->prepare("UPDATE customer set address = :address WHERE ssn = :ssn");
		$stmt->bindParam(':address', $address);
		$stmt->bindParam(':ssn', $ssn);
		$stmt->execute();
		//check if that name exists in author, then update that as well
		$stmt = $conn->prepare("UPDATE author set address = :address WHERE ssn = :ssn");
		$stmt->bindParam(':address', $address);
		$stmt->bindParam(':ssn', $ssn);
		$stmt->execute();
		$stmt = $conn->prepare("UPDATE people set address = :address WHERE ssn = :ssn");
		$stmt->bindParam(':address', $address);
		$stmt->bindParam(':ssn', $ssn);
		$stmt->execute();
		
		$stmt = $conn->prepare("SET FOREIGN_KEY_CHECKS=1;");
		$stmt->execute();
		$conn->commit();
	} catch (Exception $e) {
		$conn->rollBack();
		return -1;
	}
}
function doPartNine($conn, $data) {
	try {
		$conn->beginTransaction();
		//Inserts new Author
		if(empty($data['author']['aid'])){
			$stmt = $conn->prepare("INSERT INTO `people`(`name`, `address`, `ssn`, `telephone`, `email`)  VALUES (?,?,?,?,?)");
			$stmt->execute(array($data['author']['name'], $data['author']['address'], $data['author']['ssn'], $data['author']['telephone'], $data['author']['email']));			
			$stmt = $conn->prepare("INSERT INTO `author`(`name`, `address`, `ssn`)  VALUES (?,?,?)");
			$stmt->execute(array($data['author']['name'], $data['author']['address'], $data['author']['ssn']));
			$aid = $conn->lastInsertId();
		}
		else{
			//Existing Author
			$aid = $data['author']['aid'];
		}
		
		//Inserts new Publisher
		if(empty($data['book']['pname'])){			
			$stmt = $conn->prepare("INSERT INTO `publisher`(`pname`, `city`, `state`) VALUES (?,?,?)");
			$stmt->execute(array($data['publisher']['pname'], $data['publisher']['city'], $data['publisher']['state']));
			$pname = $data['publisher']['pname'];
		}
		else{
			//Existing Publisher
			$pname = $data['book']['pname'];
		}
		
		//Inserts Book
		if($aid){
			$stmt = $conn->prepare("INSERT INTO `book`(`ISBN13`, `title`, `year`, `category`, `pname`, `price`) VALUES (?,?,?,?,?,?)");
			$stmt->execute(array($data['book']['ISBN13'], $data['book']['title'], $data['book']['year'], $data['book']['category'], $pname, $data['book']['price']));			
		}
		
		//Inserts Writes
		if($aid){
			$stmt = $conn->prepare("INSERT INTO `writes`(`ISBN13`, `aid`) VALUES (?,?)");
			$stmt->execute(array($data['book']['ISBN13'], $aid));			
		}
		
		//Everything went ok, so commit changes
		$conn->commit();
	} catch (Exception $e) {
		$conn->rollBack();
		return -1;
	}
}
function doPartTen($conn, $ISBN13) {
   try {
	   $conn->beginTransaction();
	   
       $stmt = $conn->prepare("SELECT count(a.aid) as cnt, a.aid FROM author a, book b, writes w WHERE b.ISBN13=:ISBN13 AND w.aid = a.aid AND w.ISBN13 = b.ISBN13");
       $stmt->execute(array(':ISBN13' => $ISBN13));
       $results = $stmt->fetch();
	   
       $stmt = $conn->prepare("DELETE FROM writes WHERE ISBN13=:ISBN13");
       $stmt->execute(array(':ISBN13' => $ISBN13));
	   
       $stmt = $conn->prepare("DELETE FROM purchase WHERE ISBN13=:ISBN13");
       $stmt->execute(array(':ISBN13' => $ISBN13));
	   
	   
       $stmt = $conn->prepare("DELETE FROM book WHERE ISBN13=:ISBN13");
       $stmt->execute(array(':ISBN13' => $ISBN13));
       if (intval($results["cnt"]) == 1) {
           $aid = intval($results["aid"]);
           $stmt = $conn->prepare("DELETE FROM author WHERE aid=:aid");
           $stmt->execute(array(':aid' => $aid));
       }
	   
	   $conn->commit();
   } catch (Exception $e) {
	   $conn->rollBack();
       return -1;
   }
}

header("Location: /project/guest.php?option=" . $_SESSION['ans_num']);
?>