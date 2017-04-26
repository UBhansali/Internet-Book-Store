<?php
class Publisher {
	private $name, $city, $state;

	function __construct($name, $city, $state) {
		$this -> name = $name;
		$this -> city = $city;
		$this -> state = $state;
	}
	
	function getName() { return $this -> name; }
	function getCity() { return $this -> city; }
	function getState() { return $this -> state; }
}
?>