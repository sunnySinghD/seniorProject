<?php

require_once('Classes/Hours.php');

require_once('PHPUnit/Autoload.php');

class TestHours extends PHPUnit_Framework_TestCase{
	
	public $hours;
	public $student;
	public $date;
	public $start;
	public $end;
	public $status;
	public $task;
	
	public function setup(){
		
		$this->date = date("m/d/y");
		$this->start = "11:00";
		$this->end = "12:00";
		$this->status = "Open";
		$this->task = "Working";
		
		
		$this->student = new Student("studentA", "first", "last");
		
		$this->hours = new Hours($this->student->username, $this->date, $this->start, $this->end, $this->task, $this->status);
		
	}
	
	public function test_Constructor(){
		
		//constructor is called in setup()
		$this->assertEquals($this->hours->username,$this->student->username);
		$this->assertEquals($this->hours->date,$this->date);
		$this->assertEquals($this->hours->start,$this->start);
		$this->assertEquals($this->hours->end,$this->end);
		$this->assertEquals($this->hours->status,$this->status);
		$this->assertEquals($this->hours->task,$this->task);
		$this->assertEquals($this->hours->id,-1);
		
	}
	
	public function testWrite(){
		
		$this->hours->write();
		
		$this->assertGreaterThan(-1,$this->hours->id);
		
		$result = $this->hours->DBHelper->getHourById($this->hours->id);
		
		$this->assertEquals($this->hours->id,$result->id);
		
		
		
	}
	/**
	 * @depends testWrite
	 * Determines if the Hours were deleted
	 */
	public function testClear(){
		$this->hours->clear();
		
		$result = $this->hours->DBHelper->getHourById($this->hours->id);
		
		$this->assertNull($result);
		
		//this test is passing when it has not deleted the DB entry!!!!!
		//$this->assertTrue(False);
		
	}
	
	
}




?>