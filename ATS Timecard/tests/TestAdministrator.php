<?php 

require_once 'PHPUnit/Autoload.php';

require_once 'Classes/Administrator.php';

class TestAdministrator extends PHPUnit_Framework_Testcase{
	
	public $administrator;
	
	
	public function setUp(){
		$this->administrator = new Administrator("AdministratorA", "first", "last");
		
	}
	
	public function testConstructor(){
		
		//administrator constructed in setUP()
		
		$this->assertEquals("first", $this->administrator->fName);
		$this->assertEquals("last", $this->administrator->lName);
		$this->assertEquals("AdministratorA", $this->administrator->username);
		$this->assertEquals("Administrator", $this->administrator->type);
		
	}
	
}

?>
