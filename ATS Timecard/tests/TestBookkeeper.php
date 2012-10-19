<?php

require_once 'PHPUnit/Autoload.php';

require_once 'Classes/Bookkeeper.php';

class TestBookkeeper extends PHPUnit_Framework_Testcase{
	
	public $bookkeeper;
	
	
	public function setUp(){
		$this->bookkeeper = new Bookkeeper("BookkeeperA", "first", "last");
		
	}
	
	public function testConstructor(){
		
		//bookkeeper constructed in setUP()
		
		$this->assertEquals("first", $this->bookkeeper->fName);
		$this->assertEquals("last", $this->bookkeeper->lName);
		$this->assertEquals("BookkeeperA", $this->bookkeeper->username);
		$this->assertEquals("Bookkeeper", $this->bookkeeper->type);
		
	}
	
}




?>