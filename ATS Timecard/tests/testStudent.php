<?php
require_once 'PHPUnit/Autoload.php';

require_once 'Classes/Student.php';

class TestStudent extends PHPUnit_Framework_TestCase{
	
	public $student;
	
	
	public function setUp(){
		$this->student = new Student("StudentA", "first", "last");
		
	}
	
	public function testConstructor(){
		
		//student constructed in setUP()
		
		$this->assertEquals("first", $this->student->fName);
		$this->assertEquals("last", $this->student->lName);
		$this->assertEquals("StudentA", $this->student->username);
		$this->assertEquals("Student", $this->student->type);
		
	}
	
}




?>