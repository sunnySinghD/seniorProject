<?php

class TimeHelper
{
    public $today = "";

    const timezone = 'EST';

	// constructor for timehelper
    function __construct() {
    	date_default_timezone_set(self::timezone);
        $today = date("m/d/y");
    }


    // Returns first day of the week
    // Can also give an input to increment to a specific day in the week
    public function first_day_of_week($add=0) {
    	$todaysDay = date("N");
    	$diff = 0;
    	while ($todaysDay != 1) {
    		$todaysDay = $todaysDay - 1;
    		$diff = $diff + 1;
    	}

    	$firstDayOfWeek = date("d")-$diff;
    	$date = date("m/d/y", mktime(0,0,0,date("m"),$firstDayOfWeek+$add,date("y")));

    	return $date;
    }

    public function offsetDay($date, $offset) {
    	$date=strtotime($date);
    	$d = date("m/d/y", mktime(0,0,0,date("m",$date),date("d",$date)+$offset, date("y", $date)));

    	return $d;
    }
    
	// retrieves the first day of the week, give a single day
    public function firstDayOfWeek($day) {
    	$time = strtotime($day);
    	if(date("N", $time) == 7){return $day;}
    	else { return date("m/d/y", strtotime("last Sunday", $time)); }
    }
    
    public function weeksOfYear() {
		$weeks = array();
    	$sunday = strtotime('sunday', mktime(0, 0, 0, 1, 1, date("y")));
    	while (date("y", $sunday) == date("y")) {
    		$weeks[] = date("m/d/y", $sunday);
    		$sunday = strtotime('+1 week', $sunday);
    	}
    	
    	return $weeks;
    }
    
	// retrieves all dates between the start and end dates
    public function datesBetween($startDate, $endDate){  

		$endDate = strtotime($endDate);  
  		$currDate = strtotime($startDate); 

  		$days = array();
  		for($currDate; $currDate <= $endDate; $currDate+=86400){  
  			$days[] = date("m/d/y", $currDate);
 		}  
		return $days; 
    }

    // Returns true if the given day is in the given week, false otherwise
    public function inWeek($day, $week){
    	   	$start = $week;
		$end = $this->offsetDay($week, 7);
		$between = $this->datesBetween($start, $end);
		foreach ($between as $i){
			if ($i == $day) return true;
		}
		return false;
    }

    // Calculates time between two times
    // Returns an hour:minute time period
    public function timeBetween($startTime, $endTime){
    	$difHr = date("G", strtotime($startTime));
	$difMin = date("i", strtotime($startTime));
    	$diff = date("G:i", strtotime($endTime." - ".$difHr." hour - ".$difMin." min"));
	return $diff;
    }

    // Returns the sum of a list of hours
    // Can't use built-in date in case a student works more than 24 hours in a week
    public function totalHours($array) {
    	$totalHr = 0;
	$totalMin = 0;
	$total = 0;
    	foreach ($array as $time) {
	    $difHr = $this->extractHour($time);
	    $totalHr += intval($difHr);
	    $difMin = $this->extractMin($time);
	    $totalMin += intval($difMin);
	}
	$totalHr += intval($totalMin / 60);
	$totalMin = $totalMin % 60; // Make sure minutes < 60
	$total = $totalHr.":".$totalMin;
	return $total;
    }

    // Returns hour from a time
    public function extractHour($time) {
    	$hour = "";
	$time = preg_split('//', $time, -1, PREG_SPLIT_NO_EMPTY); // split string into array
        foreach ($time as $i) {
	    if ($i == ":") {
	        break;
	    }
	    $hour = $hour.$i;
	}
	return $hour;
    }

    // Returns minutes from a time
    public function extractMin($time) {
    	$start = 0;
    	$min = "";
	$time = preg_split('//', $time, -1, PREG_SPLIT_NO_EMPTY); // split string into array
        foreach ($time as $i) {
	    if ($start==1) {
	       $min = $min.$i;
	    }
	    if ($i == ":") {
	        $start = 1;
	    }
	}
	return $min;
    }
    
    //converts a time in the format "1:00" to a decimal number
	function hoursToDecimal($time) {
    	$timeArr = explode(':', $time);
    	$decTime = ($timeArr[0]) + ($timeArr[1]/60);
 
    	return $decTime;
	}
	
	//rounds the hours according to ATS standard
	/**
	 *  1- 6 minutes = .1 hours
	 *  7-2 = .2
	 *  13-18 = .3
	 *  19-24 = .4
	 *  25-30 = .5
	 *  31-36 = .6
	 *  37-42 = .7
	 *  43-48 = .8
	 *  49-54 = .9
	 *  55-60 = 1
	 *  
	 *  takes a time in decimal format, and rounds the number of hours
	 */
	function roundHours($hours){
		//round the hours according to their specification
		
		$timeArr = explode(':', $time);
    	
		//hours do not need to be rounded
		$decHours = $timeArr[0];
		
		$unroundedMinutes = $timeArr[1];
		$roundedMinutes = 0;
		
		if($unroundedMinutes >= 1 && $unroundedMinutes <= 6){
			$roundedMinues = .1;
		}
		else if($unroundedMinutes >= 7 && $unroundedMinutes <= 12){
			$roundedMinues = .2;
		}
		else if($unroundedMinutes >= 13 && $unroundedMinutes <= 18){
			$roundedMinues = .3;
		}
		else if($unroundedMinutes >= 19 && $unroundedMinutes <= 24){
			$roundedMinues = .4;
		}
		else if($unroundedMinutes >= 25 && $unroundedMinutes <= 30){
			$roundedMinues = .5;
		}
		else if($unroundedMinutes >= 31 && $unroundedMinutes <= 36){
			$roundedMinues = .6;
		}
		else if($unroundedMinutes >= 37 && $unroundedMinutes <= 42){
			$roundedMinues = .7;
		}
		else if($unroundedMinutes >= 43 && $unroundedMinutes <= 48){
			$roundedMinues = .8;
		}
		else if($unroundedMinutes >= 49 && $unroundedMinutes <= 54){
			$roundedMinues = .9;
		}
		else if($unroundedMinutes >= 37 && $unroundedMinutes <= 42){
			$roundedMinues = 1;
		}
		
 
    	return $decTime;
		
	}
	
	/*
	 * Makes sure that the time given is a valid time format
	 * make sure time matches "0:00" or 0:00PM format
	 */
	function handleTimeInput($time){
		
		$noError = true;
		
		$splitTime = trim($time);
		//echo $splitTime."\n";
		$splitTime = explode(":", $time);
		
		//make sure time is split into 2 parts. improper time if size = 1 or greater than 2
		if(sizeof($splitTime) != 2){
			echo "check 1 <br>";
			$noError = false;
			return $noError;
			
		}
		else{
			//make sure hour is an integer and is within bounds
			$hour = $splitTime[0];
			
			if($hour < 1 || $hour > 12){
				echo "check 2 <br>";
				$noError = false;
				return $noError;
			}
			
			//check if minutes are correct and AM/PM is present
			
			//remove extra whitespace
			$minuteAndMeridiem = trim($splitTime[1]);
			$minuteAndMeridiem = str_replace(" ", "", $minuteAndMeridiem);
			echo $minuteAndMeridiem;
			
			if(strlen($minuteAndMeridiem) != 4){
				//the minutes and PM do not match correct format
				//echo "missing AMPM";
				echo "check 3 <br>";
				$noError = false;
				return $noError;
			}
			
			$minute = substr($minuteAndMeridiem, 0, 2);
			$meridiem = substr($minuteAndMeridiem, 2, 2);
			echo $minute. "\n";
			
			if(!(is_numeric($minute))){
				echo "not an int!<br>\n";
				echo "check 4 <br>";
				$noError = false;
				return $noError;
			}
			
			//check if the Minutes are within bounds
			if($minute < 0 || $minute > 59){
				$noError = false;
				return $noError;
			}
			
			//make all caps
			$meridiem = strtoupper($meridiem);
			//check if AM or PM
			if(!($meridiem == "AM" || $meridiem == "PM")){
				echo "meridiem does not make sense";
				$noError = false;
				return $noError;
			}
			
		}
		
		return $noError;
	}
	// adds 12 hours to any hour after noon and subtracts 12 from from midnight
	function get24Format($time){
		$splitTime = trim($time);
		//echo $splitTime."\n";
		$splitTime = explode(":", $time);
		//check if minutes are correct and AM/PM is present		
		//remove extra whitespace
		$hour=(int)$splitTime[0];
		$minuteAndMeridiem = trim($splitTime[1]);
		$minuteAndMeridiem = str_replace(" ", "", $minuteAndMeridiem);
		$minute = substr($minuteAndMeridiem, 0, 2);
		$meridiem = substr($minuteAndMeridiem, 2, 2);
		$meridiem = strtoupper($meridiem);
		if (strcmp($meridiem, "PM")==0 && $splitTime[0]!=="12") $hour+=12;
		if (strcmp($meridiem, "AM")==0 && $splitTime[0]=="12") $hour-=12;
		return $hour.":".$minute.$meridiem;
	}
	
	// determines if hours are overlapping with hours in timecard on the same day
	function hoursOverlap($time1, $time2, $username, $date){
		$currTime1 = $this->get24Format($time1);
		$noError = true;
		$cardHelper = new CardDBHelper();
		$currentHours = $cardHelper->getTimecardForDate($username, $date);
		$currTime2 = $this->get24Format($time2);
		$noError = true;
		$cardHelper = new CardDBHelper();
		$currentHours = $cardHelper->getTimecardForDate($username, $date);
		
		$checkStart = false;
		$checkEnd=false;
		foreach($currentHours as $anHour){
			// check if hours overlap with any single timecard
			if (
				((int)$currTime1 > (int)$this->get24Format($anHour->start) && (int)$currTime1 < (int)$this->get24Format($anHour->end)) ||
				((int)$currTime2 > (int)$this->get24Format($anHour->start) && (int)$currTime2 < (int)$this->get24Format($anHour->end)) || 
				((int)$currTime1 == (int)$this->get24Format($anHour->start) && (int)$currTime2 == (int)$this->get24Format($anHour->end))) {
				
				$noError = false;
				//echo "check 5 <br>";
				return $noError;
			}
			// check if hours overlap multiple timecards
			if ((int)$currTime1 == (int)$this->get24Format($anHour->start)) $checkStart = true;
			if ((int)$currTime2 == (int)$this->get24Format($anHour->end)) $checkEnd = true;
		}
		if ($checkStart && $checkEnd){
			$noError = false;
		}
		return $noError;
	}
	
	function getHoursInDay($day){
		$dayTotal = 0;
		foreach($day->hours as $hours){

			$decHours = number_format($this->hoursToDecimal($this->timeBetween($hours->start, $hours->end)), 2);
			$dayTotal += $decHours;

	    }
	    $dayTotal = number_format($dayTotal, 2);
	    
	    return $dayTotal;
	}

		
}
	


?>
