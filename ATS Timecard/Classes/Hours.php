<?php
include_once ('CardDBHelper.php');

class Hours
{
	// id number
	public $id;
	// username associated with hours
	public $username;
	
	// internal variables of hours
	public $date;
	public $start;
	public $end;
	public $task;
	public $status;
	
	public $CardDBHelper;
	
	// constructor of hours
	function __construct($username, $date, $start, $end, $task, $status) {
		// initialize internal variables with input to constructor
		$this->id = -1;
		$this->username = $username;
		$this->date = $date;
		$this->start = $start;
		$this->end = $end;
		$this->task = $task;
		$this->status = $status;
       
		$this->CardDBHelper = new CardDBHelper();
       
	}
   
	// write a set of hours back to the database
	public function write(){
		// if these are not entirely new hours (if an id has already
		//   been set), we must first clear the hours already in the
		//   database with the same id
		if($this->id != -1) {$this->clear();}
		// write the hours to the database, and retrieve the new
		//  id number returned from the add to the database
   		$this->id = $this->CardDBHelper->writeHours($this);
	}
   
   // remove this set of hours from the database
   public function clear(){
   		$this->CardDBHelper->deleteHours($this);
   }
	
}

?>