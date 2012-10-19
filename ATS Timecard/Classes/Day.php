<?php
include_once ('CardDBHelper.php');

class Day
{
	// username associated with the day
	public $username;
	// database helper for the day to make use of
	public $CardDBHelper;
	
	// date associated with day
	public $date;
	// day of the week associated with day
	public $dayOfWeek;
	// the set of hours associated with the day
	public $hours;
	// the number of hour sets in the day
	public $size;
	
	// constructor for day
	function __construct($username, $date) {
		// initiate internal variables appropriately
		$this->CardDBHelper = new CardDBHelper();
   		$this->date = $date;
   		// retrieve the hours from the database
		$this->hours = $this->CardDBHelper->getTimecardForDate($username, $date);	
		
		$this->size = count($this->hours);
		$this->dayOfWeek = date("D", strtotime($this->date));   
   }	
}

?>