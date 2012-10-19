<?php

require_once('Classes/User.php');

require_once 'PHPUnit/Autoload.php';
require_once "Classes/DBHelper.php";
require_once "Classes/Student.php";


class TestUser extends PHPUnit_Framework_TestCase{
	
	public $User;
	
	protected function setUp(){
		$this->User = new User("UserA");
		$this->User->fName = "first";
		$this->User->lName = "last";
		$this->User->type = "Supervisor";
		
	}
	
	protected function tearDown(){
		

	}
	
	public function testUserConstruct(){
		$this->assertEquals("UserA", $this->User->username);
	}
	
	public function testLogin(){
		//get the user from the DB
		$this->User = $this->User->login("stud");
		
		//Check if the values in User, equal the values form the DB
		$fname = "Mike";
		$lname = "Lopez";
		$type = "Student";
		
		$this->assertEquals("stud", $this->User->username);
		$this->assertEquals($fname, $this->User->fName);
		$this->assertEquals($lname, $this->User->lName);
		$this->assertEquals($type, $this->User->type);
		
	}
	
	public function testAddSelf(){
		
		$this->User->addSelf($this->User->type);
		
		$result = $this->User->DBHelper->getUser($this->User->username);
		
		$this->assertEquals($this->User->username, $result->username);
		
	}
	

	public function testEditSelf(){
		
		$this->User = $this->User->login("UserA");
		
		$this->User->editSelf("Supervisor");
		$this->assertEquals($this->User->type, "Supervisor");
		
		$this->User->editSelf("Administrator");
		$this->assertEquals($this->User->type, "Administrator");
		

		
	}
	
	
	public function testAddRelations(){
		
		
	}
	
	
	/**
	 * @depends testAddSelf
	 * Enter description here ...
	 */
	public function testRemoveSelf(){
		
		$this->User->removeSelf();
		
		$result = $this->User->DBHelper->getUser($this->User->username);
		
		$this->assertEquals($result,null);
		
	}
	
	
	public function testGetUsernames(){
		$types = array("Supervisor");
		$results = $this->User->getUsernames($types);
		
		foreach($results as $user){
			$this->assertEquals("Supervisor", $user->type);
		}
	}
	
	

	
}



?>
