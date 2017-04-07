<?php
class Book {
	private $ISBN, $title, $year, $category, $price, $author, $publisher;

	function __construct($bISBN, $btitle, $byear, $bcategory, $bprice, $author, $publisher) {
		$this->ISBN = $bISBN;
		$this->title = $btitle;
		$this->year = $byear;
		$this->category = $bcategory;
		$this->price = $bprice;
		$this->author = $author;
		$this->publisher = $publisher;
	}

	function getISBN() { return $this -> $ISBN; }
	function getTitle() { return $this -> $title; }
	function getYear() { return $this -> $year; }
	function getCategory() { return $this -> $category; }
	function getPrice() { return $this -> $price; }
	function getAuthor() { return $this -> $author; }
	function getPublisher() { return $this -> $publisher; }
}
?>