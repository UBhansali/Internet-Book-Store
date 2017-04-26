<?php
class Author {
	private $name, $address, $ssn;

	function __construct($name, $address, $ssn) {
		$this -> name = $name;
		$this -> address = $address;
		$this -> ssn = $ssn;
	}

	function getName() { return $this -> name; }
	function getAddress() { return $this -> address; }
	function getSSN() { return $this -> ssn; }
}
?>