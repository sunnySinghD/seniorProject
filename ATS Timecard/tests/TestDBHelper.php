<?php


require_once "Classes/UserDBHelper.php";
require_once 'Classes/User.php';
require_once "Classes/Student.php";

require_once 'PHPUnit/Autoload.php';



// must run databasegen and authdatabasegen first
include('scripts/databaseGen.php');
include('scripts/authDatabaseGen.php');

class TestDBHelper extends PHPUnit_Framework_TestCase
{
	public $DBHelper;
	public $Student;
	public $CardDBHelper;
	/*
	 * Perform this before every test
	 */
	protected function setUp(){
		
		$this->DBHelper = new UserDBHelper();
		$this->CardDBHelper = new CardDBHelper();
	}
	
	public function tearDown(){
		
		
	}
	
	// test if DBHelper can add users, testing on Students, Supervisors, Bookkeepers, and admins
	public function testAdding(){
		
		$s=new Student("testS", "Sf", "Sl");
		$this->DBHelper->addUser($s, "Student");
		// after adding, look for the new student
		$sql="SELECT * FROM users WHERE Username='testS'";
		$result = mysql_query($sql);
		$array=mysql_fetch_array($result);
		// add a student and then test to see if that student is there
		$this->assertTrue($array['Username'] == "testS");
		
		$s=new Supervisor("testSu", "Suf", "Sul");
		$this->DBHelper->addUser($s, "Supervisor");
		// after adding, look for the new supervisor
		$sql="SELECT * FROM users WHERE Username='testSu'";
		$result = mysql_query($sql);
		$array=mysql_fetch_array($result);
		// add a supervisor and then test to see if that supervisor is there
		$this->assertTrue($array['Username'] == "testSu");
		
		$s=new Bookkeeper("testB", "Bf", "Bl");
		$this->DBHelper->addUser($s, "Bookkeeper");
		// after adding, look for the new bookkeeper
		$sql="SELECT * FROM users WHERE Username='testB'";
		$result = mysql_query($sql);
		$array=mysql_fetch_array($result);
		// add a bookkeeper and then test to see if that bookkeeper is there
		$this->assertTrue($array['Username'] == "testB");
		
		$s=new Supervisor("testA", "Af", "Al");
		$this->DBHelper->addUser($s, "Administrator");
		// after adding, look for the new admin
		$sql="SELECT * FROM users WHERE Username='testA'";
		$result = mysql_query($sql);
		$array=mysql_fetch_array($result);
		// add an admin and then test to see if that admin is there
		$this->assertTrue($array['Username'] == "testA");
		
		
	}
	/**
	@depends testAdding
	*/ 
	// tests removing users, runs on students, supervisors, bookkeepers, and admins
	public function testRemove(){
		$s=new Student("testS", "S", "S");
		$this->DBHelper->removeUser($s);
		// after removing, look for the removed user
		$sql="SELECT * FROM users WHERE Username='testS'";
		$result = mysql_query($sql);
		$array=mysql_fetch_array($result);
		$this->assertFalse($array);
		
		$s=new Supervisor("testSu", "Suf", "Sul");
		$this->DBHelper->removeUser($s);
		// after removing, look for the removed supervisor
		$sql="SELECT * FROM users WHERE Username='testSu'";
		$result = mysql_query($sql);
		$array=mysql_fetch_array($result);
		$this->assertFalse($array);
		
		$s=new Bookkeeper("testB", "Bf", "Bl");
		$this->DBHelper->removeUser($s);
		// after removing, look for the removed bookkeeper
		$sql="SELECT * FROM users WHERE Username='testB'";
		$result = mysql_query($sql);
		$array=mysql_fetch_array($result);
		$this->assertFalse($array);
		
		$s=new Administrator("testA", "Af", "Al");
		$this->DBHelper->removeUser($s);
		// after removing, look for the removed admin
		$sql="SELECT * FROM users WHERE Username='testA'";
		$result = mysql_query($sql);
		$array=mysql_fetch_array($result);
		$this->assertFalse($array);
		
		// try removing a nonexistant user then look for it
		$s=new Student("testS2", "S2", "S2");
		$this->DBHelper->removeUser($s);
		$sql="SELECT * FROM users WHERE Username='testS2'";
		$result = mysql_query($sql);
		$array=mysql_fetch_array($result);
		$this->assertFalse($array);
		
	}
	
	/**
	 * depends testRemove
	 */
	// two assertions to check if logging in works (successful login() returns username)
	// incidentally this also depends on testAdding but thats implied with testRemove
	public function testLogin()
	{
		$s=new Student("testS", "S", "S");
		// checking if a nonexistant student can login
		$this->assertNotEquals($s, $s->login("testS"));
		// adding same student to database
		$this->DBHelper->addUser($s, "Student");
		// checking if an existing student can login
		$this->assertEquals($s, $s->login("testS"));
		
		$s=new Supervisor("testSu", "Suf", "Sul");
		// checking if a nonexistant supervisor can login
		$this->assertNotEquals($s, $s->login("testSu"));
		// adding same supervisor to database
		$this->DBHelper->addUser($s, "Supervisor");
		// checking if an existing supervisor can login
		$this->assertEquals($s, $s->login("testSu"));
		
		$s=new Bookkeeper("testB", "Bf", "Bl");
		// checking if a nonexistant bookkeeper can login
		$this->assertNotEquals($s, $s->login("testB"));
		// adding same bookkeeper to database
		$this->DBHelper->addUser($s, "Bookkeeper");
		// checking if an existing bookkeeper can login
		$this->assertEquals($s, $s->login("testB"));
		
		$s=new Administrator("testA", "Af", "Al");
		// checking if a nonexistant admin can login
		$this->assertNotEquals($s, $s->login("testA"));
		// adding same admin to database
		$this->DBHelper->addUser($s, "Administrator");
		// checking if an existing admin can login
		$this->assertEquals($s, $s->login("testA"));
	}
	
	public function testTimecards(){
		$result = $this->CardDBHelper->getTimecards('usernA', '11/01/11');
		// should evaluate to false if there are no timecards
		//$this->assertFalse(mysql_result($result, 0));

		$result = $this->CardDBHelper->getTimecards('stud','11/02/11');
		// should hold timecard information
		$this->assertNotNull(mysql_result($result, 0));
	}

	public function testLogHours(){
		//hello
	}

}


/**
 * change your run configuration to go through TestSuite.php instead of TestDBHelper.php
 * 
 * that way it will do all the tests that aren't commented in testSuite.php
 */

# run the test
#$suite = new PHPUnit_Framework_TestSuite('testDB');
#PHPUnit_TextUI_TestRunner::run($suite);

?>
