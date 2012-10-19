<?php

include_once('Day.php');
include_once('Hours.php');
include_once('TimeHelper.php');


class Timecard
{
	// username associated with the timecard
	public $username;
	
	// variable for storing the days associated with the timecard
	public $days;
	// status of the timecard (submitted, unsubmitted, etc)
	public $status;
	
	// constructor for timecard
	function __construct($username, $date) {
		// set username appropriately
		$this->username = $username;
		
		// set up internal variables
		$this->time = new TimeHelper();
		$this->days = array();
		
		// get all dates in the week that the timecard covers
		$datesInWeek = $this->time->datesBetween($date, $this->time->offsetDay($date, 6));
		// for each of the dates, add an appropriately constructed
		//   day structure to the array of days
		for($i=0;$i<7;$i++){
			$this->days[] = new Day($username, $datesInWeek[$i]);
		}
		$this->status = $this->getStatus();
		
	}
	
	// retrieves the timecard's status
	private function getStatus(){
		$key = NULL;
		// find a day containing a set of hours (and therefore a status)
		foreach($this->days as $day){if($day->size > 0){$key = $day;}}
		// retrieve the located status
		return $key? $key->hours[0]->status : '';
	}

}

?>