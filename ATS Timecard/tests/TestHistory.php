<?php

require_once('Classes/History.php');

require_once('PHPUnit/Autoload.php');

class TestHistory extends PHPUnit_Framework_TestCase{
	
	public $history;
	
	public $description;
	public $time;
	public $date;
	public $username;
	
	
	public function setup(){
		
		$this->description = "description";
		$this->time = date("H:i:s");
		$this->date = date("m/d/y");
		$this->username = "HistoryTest";
		
		$this->history = new History($this->username, $this->description, $this->date, $this->time);
		
	}
	
	public function test_Constructor(){
		
		//constructed in setup();
		$this->assertEquals($this->history->description, $this->description);
		$this->assertEquals($this->history->username, $this->username);
		$this->assertEquals($this->history->date, $this->date);
		$this->assertEquals($this->history->time, $this->time);

		
	}
	
	public function testGetDescription(){
		$result = $this->history->get_description();
		$this->assertEquals($this->description, $result);
	}
	
	public function testGetTime(){
		$result = $this->history->get_time();
		$this->assertEquals($this->time, $result);
	}
	
	public function testGetDate(){
		$result = $this->history->get_date();
		$this->assertEquals($this->date, $result);
	}
	
	public function testWrite(){
		$result = $this->history->write();
		
		$this->assertTrue($result);

	}

	
}


?>