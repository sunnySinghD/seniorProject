<?php

require_once 'PHPUnit/Autoload.php';

require_once 'Classes/Supervisor.php';

class TestSupervisor extends PHPUnit_Framework_Testcase{
	
	public $supervisor;
	
	
	public function setUp(){
		$this->supervisor = new Supervisor("SupervisorA", "first", "last");
		
	}
	
	public function testConstructor(){
		
		//supervisor constructed in setUP()
		
		$this->assertEquals("first", $this->supervisor->fName);
		$this->assertEquals("last", $this->supervisor->lName);
		$this->assertEquals("SupervisorA", $this->supervisor->username);
		$this->assertEquals("Supervisor", $this->supervisor->type);
		
	}
	
}




?>