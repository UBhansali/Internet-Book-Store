<?php 
session_start(); 
$option = (isset($_GET['option'])) ? $_GET['option'] : "part1"; 
require_once("database.php");
?>
<html>
<head><title>Project</title></head>
<body>
	<h2>Welcome to the BookPlace!</h2>
	<br/><br/>
	<p>Please choose an option from the dropdown.</p>
	<form action="backend.php" method="POST">
		<select name="part_select">
			<option value="part1" <?php if ($option == "part1" || substr($option, 0, 3) != "part") print "selected"; ?>>Part 1</option>
			<option value="part2" <?php if ($option == "part2") print "selected"; ?>>Part 2</option>
			<option value="part3" <?php if ($option == "part3") print "selected"; ?>>Part 3</option>
			<option value="part4" <?php if ($option == "part4") print "selected"; ?>>Part 4</option>
			<option value="part5" <?php if ($option == "part5") print "selected"; ?>>Part 5</option>
			<option value="part6" <?php if ($option == "part6") print "selected"; ?>>Part 6</option>
			<option value="part7" <?php if ($option == "part7") print "selected"; ?>>Part 7</option>
			<option value="part8" <?php if ($option == "part8") print "selected"; ?>>Part 8</option>
			<option value="part9" <?php if ($option == "part9") print "selected"; ?>>Part 9</option>
			<option value="part10" <?php if ($option == "part10") print "selected"; ?>>Part 10</option>
		</select>
		<input type="hidden" name="type" value="select" />
		<input type="submit" value="Go" />
	</form>
	<?php if ($option == "part1" || substr($option, 0, 4) != "part") { ?>
	<h2>Part 1</h2>
	<div>
		<span>Find the names of authors who have purchased a book written by themselves. (aid and cid will not be the same).</span>
		<div>
			<form action="backend.php" method="POST">
				<input type="hidden" name="type" value="part1" />
				<input type="submit" value="Submit" />
			</form>
		</div>
	</div>
	<?php } ?>

	<?php if ($option == "part2") { ?>
	<h2>Part 2</h2>
	<div>
		<span>User input one author name, find all the books written by the author(s).</span>
		<div>
			<form action="backend.php" method="POST">
				<input type="text" name="auth_name" placeholder="Name of author" />
				<input type="hidden" name="type" value="part2" />
				<input type="submit" value="Submit" />
			</form>
			<?php if (isset($_SESSION['ans']) && isset($_SESSION["ans_num"]) && $_SESSION["ans_num"] == "part2") { ?>
			<table>
				<thead><tr><th><b>ISBN13</b></th><th><b>Title</b></th><th><b>Year</b></th><th><b>Category</b></th><th><b>Publisher</b></th><th><b>Price</b></th></tr></thead>
				<tbody><?php
				foreach ($_SESSION['ans'] as $obj)
				{
					print "<tr><td>$obj[ISBN13]</td><td>$obj[title]</td><td>$obj[year]</td><td>$obj[category]</td><td>$obj[pname]</td><td>$obj[price]</td></tr>";
				}
			    ?></tbody>
			</table>
			<?php } unset($_SESSION['ans']); unset($_SESSION['ans_num']); ?>
		</div>
	</div>
	<?php } ?>

	<?php if ($option == "part3") { ?>
	<h2>Part 3</h2>
	<div>
		<span>User input one customer name, find purchase history of the customer(s).</span>
		<div>
			<form action="backend.php" method="POST">
				<input type="text" name="author" placeholder="Name of customer" />
				<input type="hidden" name="type" value="part3" />
				<input type="submit" value="Submit" />
			</form>
			<?php if (isset($_SESSION['ans']) && isset($_SESSION["ans_num"]) && $_SESSION["ans_num"] == "part3") { 
				date_default_timezone_set('America/New_York');
				foreach ($_SESSION['ans'] as $obj)
				{
					$datetime = date("l", $obj['datetime']);
					print "<b>On $datetime, $_SESSION[cust_name]</b> bought <b>$obj[title]</b> for $obj[price].<br/>";
				}
			} unset($_SESSION['ans']); unset($_SESSION['ans_num']); ?>
		</div>
	</div>
	<?php } ?>

	<?php if ($option == "part4") { ?>
	<h2>Part 4</h2>
	<div>
		<span>User input one or more words of a book title, find all information of the books whose titles contain those words.</span>
		<div>
			<form action="backend.php" method="POST">
				<input type="text" name="keywords" placeholder="Book title" />
				<input type="hidden" name="type" value="part4" />
				<input type="submit" value="Submit" />
			</form>
			<?php if (isset($_SESSION['ans']) && isset($_SESSION["ans_num"]) && $_SESSION["ans_num"] == "part4") {
				var_dump($_SESSION['ans']);
				foreach ($_SESSION['ans'] as $obj)
				{
					print "<pre><code>";
					print_r($obj);
					print "</code></pre>";
				}
			} unset($_SESSION['ans']); unset($_SESSION['ans_num']); ?>
		</div>
	</div>
	<?php } ?>

	<?php if ($option == "part5") { ?>
	<h2>Part 5</h2>
	<div>
		<span>Design a drop down menu so user can use it to select a year and find the title of the best selling book of that year.</span>
		<div>
			<form action="backend.php" method="POST">
				<select name="year">
					<?php 
					try {
						$stmt = $conn->prepare("SELECT distinct(b.year) FROM book b ORDER by b.year ASC");
						$stmt->execute();
						$years = $stmt->fetchAll();
					} catch (Exception $e) {
						die($e);
					}					
					foreach($years as $year):?>
						<option value="<?php echo $year['year'];?>" <?php if(isset($_SESSION['year']) && $_SESSION['year'] == $year['year']) echo 'selected';?>>
							<?php echo $year['year'];?>
						</option>
					<?php endforeach;?>
				</select>
				<input type="hidden" name="type" value="part5" />
				<input type="submit" value="Submit" />
			</form>	

			<?php if (isset($_SESSION['ans']) && isset($_SESSION["ans_num"]) && $_SESSION["ans_num"] == "part5") { ?>
			<table>
				<thead><tr><th><b>ISBN13</b></th><th><b>Title</b></th><th><b>Year</b></th><th><b>Category</b></th><th><b>Publisher</b></th><th><b>Price</b></th><th><b>Purchases</b></th></tr></thead>
				<tbody><?php
				foreach ($_SESSION['ans'] as $obj)
				{
					print "<tr><td>$obj[ISBN13]</td><td>$obj[title]</td><td>$obj[year]</td><td>$obj[category]</td><td>$obj[pname]</td><td>$obj[price]</td><td>$obj[purchases]</td></tr>";
				}
			    ?></tbody>
			</table>
			<?php } unset($_SESSION['ans']); unset($_SESSION['ans_num']); ?>			
		</div>
	</div>
	<?php } ?>

	<?php if ($option == "part6") { ?>
	<h2>Part 6</h2>
	<div>
		<span>Record the information that a customer has purchased a book.</span>
		<div>
			<form action="backend.php" method="POST">
			
				<select name="ISBN13">
					<?php 
					try {
						$stmt = $conn->prepare("SELECT * FROM book b ORDER by b.title ASC");
						$stmt->execute();
						$books = $stmt->fetchAll();
					} catch (Exception $e) {
						die($e);
					}					
					foreach($books as $book):?>
						<option value="<?php echo $book['ISBN13'];?>">
							<?php echo $book['title']." (".$book['year'].")";?>
						</option>
					<?php endforeach;?>
				</select>
				<select name="cid">
					<?php 
					try {
						$stmt = $conn->prepare("SELECT * FROM customer c ORDER by c.name ASC");
						$stmt->execute();
						$customers = $stmt->fetchAll();
					} catch (Exception $e) {
						die($e);
					}					
					foreach($customers as $customer):?>
						<option value="<?php echo $customer['cid'];?>">
							<?php echo $customer['name'];?>
						</option>
					<?php endforeach;?>
				</select>				
				<input type="hidden" name="type" value="part6" />
				<input type="submit" value="Submit" />
			</form>
		</div>
	</div>
	<?php } ?>

	<?php if ($option == "part7") { ?>
	<h2>Part 7</h2>
	<div>
		<span>Add a new customer to the database.</span>
		<div>
			<form action="backend.php" method="POST">
				<input type="text" name="name" placeholder="Name" maxlength="255"/>
				<input type="text" name="address" placeholder="Address" maxlength="255"/>
				<input type="text" name="ssn" placeholder="SSN" maxlength="9"/>
				<input type="text" name="telephone" placeholder="Telephone" maxlength="10"/>
				<input type="email" name="email" placeholder="Email" maxlength="255"/>
				<input type="hidden" name="type" value="part7" />
				<input type="submit" value="Submit" />
			</form>		
		</div>
	</div>
	<?php } ?>

	<?php if ($option == "part8") { ?>
	<h2>Part 8</h2>
	<div>
		<span>User input one name and address, update the address in people, and author or customer table if applicable.</span>
		<div>
			<form action="backend.php" method="POST">
				<select name="ssn">
					<?php 
					try {
						$stmt = $conn->prepare("SELECT * FROM people p ORDER by p.name ASC, p.ssn ASC");
						$stmt->execute();
						$people = $stmt->fetchAll();
					} catch (Exception $e) {
						die($e);
					}					
					foreach($people as $person):?>
						<option value="<?php echo $person['ssn'];?>">
							<?php echo $person['name']." (SSN: ".$person['ssn'].")";?>
						</option>
					<?php endforeach;?>
				</select>
				<input type="text" name="address" placeholder="Address" maxlength="255"/>
				<input type="hidden" name="type" value="part8" />
				<input type="submit" value="Submit" />
			</form>		
		</div>
	</div>
	<?php } ?>

	<?php if ($option == "part9") { ?>
	<h2>Part 9</h2>
	<div>
		<span>Add a new book to the database. If the author and/or the publisher of the new book is not in the database, insert all information about the author and/or publisher as well.</span>
		<div>
			<form action="backend.php" method="POST">
				<fieldset>
					<legend>New Book</legend>
					<input type="text" name="book[ISBN13]" placeholder="ISBN13" maxlength="13"/>
					<input type="text" name="book[title]" placeholder="Title" maxlength="255"/>
					<input type="number" name="book[year]" placeholder="Year"/>
					<input type="text" name="book[category]" placeholder="Category" maxlength="255"/>
					<!--<input type="text" name="book[pname]" placeholder="Category" maxlength="255"/>-->
					<input type="number" name="book[price]" placeholder="Price"/>
				</fieldset>

				<fieldset>
					<legend>Book Author</legend>
					
					<select name="author[aid]">
						<option value="">Select an Author</option>
						<?php 
						try {
							$stmt = $conn->prepare("SELECT * FROM author a ORDER by a.name ASC");
							$stmt->execute();
							$authors = $stmt->fetchAll();
						} catch (Exception $e) {
							die($e);
						}					
						foreach($authors as $author):?>
							<option value="<?php echo $author['aid'];?>">
								<?php echo $author['name'];?>
							</option>
						<?php endforeach;?>
					</select>
					
					<br/><br/>
					<span>New Author:</span>
					<br/>
					
					<input type="text" name="author[name]" placeholder="Name" maxlength="255"/>
					<input type="text" name="author[address]" placeholder="Address" maxlength="255"/>
					<input type="text" name="author[ssn]" placeholder="SSN" maxlength="9"/>
					<input type="text" name="author[telephone]" placeholder="Telephone" maxlength="10"/>
					<input type="email" name="author[email]" placeholder="Email" maxlength="255"/>
				</fieldset>
				
				<fieldset>
					<legend>Book Publisher</legend>
					
					<select name="book[pname]">
						<option value="">Select an Publisher</option>
						<?php 
						try {
							$stmt = $conn->prepare("SELECT * FROM publisher p ORDER by p.pname ASC");
							$stmt->execute();
							$publishers = $stmt->fetchAll();
						} catch (Exception $e) {
							die($e);
						}					
						foreach($publishers as $publisher):?>
							<option value="<?php echo $publisher['pname'];?>">
								<?php echo $publisher['pname'];?>
							</option>
						<?php endforeach;?>
					</select>
					
					<br/><br/>
					<span>New Publisher:</span>
					<br/>
					
					<input type="text" name="publisher[pname]" placeholder="Name" maxlength="255"/>
					<input type="text" name="publisher[city]" placeholder="City" maxlength="255"/>
					<input type="text" name="publisher[state]" placeholder="State" maxlength="2"/>
				</fieldset>
				<br/>
				<input type="hidden" name="type" value="part9" />
				<input type="submit" value="Submit" />
				
			</form>		
		</div>
	</div>
	<?php } ?>

	<?php if ($option == "part10") { ?>
	<h2>Part 10</h2>
	<div>
		<span>Delete a book. If the author of the book has not written other books, delete the author as well.</span>
		<div>
			<form action="backend.php" method="POST">
				<select name="ISBN13">
					<?php 
					try {
						$stmt = $conn->prepare("SELECT * FROM book b ORDER by b.title ASC");
						$stmt->execute();
						$books = $stmt->fetchAll();
					} catch (Exception $e) {
						die($e);
					}					
					foreach($books as $book):?>
						<option value="<?php echo $book['ISBN13'];?>">
							<?php echo $book['title']." (".$book['year'].")";?>
						</option>
					<?php endforeach;?>
				</select>		
				<input type="hidden" name="type" value="part10" />
				<input type="submit" value="Delete" />
				
			</form>	
		</div>
	</div>
	<?php } ?>
</body>
</html>