<?php
require_once('Classes/TimeHelper.php');
require_once('Classes/Timecard.php');

require_once('PHPUnit/Autoload.php');

class TestTimecard extends PHPUnit_Framework_TestCase{
	
	public $timecard;
	public $date;
	
	public function setup(){
		$date = date("m/d/y", mktime(0,0,0,11,9,date("Y")));
		$this->timecard = new Timecard("stud", $date);
		
	}
	
	public function testGetStatus(){
		//TODO: this
	}
	
}
