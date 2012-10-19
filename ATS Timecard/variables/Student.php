<?php

class Student extends User
{
    //The student's current timecard to add and submit hours to
    public $currTimecard;
	
    //The Student's supervisor, who will approve hours
    public $supervisor;
	
   function __construct($username) {
      // print "Constructing User";
       $this->username = $username;
       $this->DBHelper = new DBHelper();
   }
	
	/**
	* LogHours:
	* @param $start Start time of hours
	* @param $end End time of hours
	* @param $date Day to add hours to
	public function LogHours($start, $end, $date){
		//Allow student to break hours up into pieces, and choose tasks for them.
		// Call insertHours for each of the broken up pieces
		
		// Once all of the hours have been added to the timecard, send timecard off
		//  to database
	}
		
    /**
    * InsertHours:
    *
    * @param $hours The amount of hours to clock
    * @param $minutes The amount of minutes to clock
    * @param $start Start time of hours
	* @param $end End time of hours
	* @param $date Day to add hours to
    * @param $comment The task the student assigned for the given hours
    *
    */
    public function insertHours($start, $end, $date, $comment){

        //insert hours into the timecard

    }

    /**
    * submitHours:
    *
    * Mark the time card as submitted
    */
    public function submitHours(){

		// use currtimecard object
		// Change its submitted boolean to true
		
		// send changes back to database

    }

    /**
    * viewTimecard:
    *
    * view the student's timecard, starting with the current pay period
    *
    */
    public function viewTimecard(){

        //select current time card from Database

	//display

    }
    
    /**
    * viewOldTimecards:
    *
    * Takes user input, and displays requested old timecards
    **/
    public function viewOldTimecards(){
    	// gets user to input the dates (weeks) they wish to view
    	// Note - checks that the user actually has timecards for those weeks
    	
    	// creates list of those timecards
    	
    	// calls displayTimecards with that list
    }
    
    /**
    * displayTimecards:
    *
    * Display the timecards requested by user - may be many
    * 
    * @param $timecards - list of timecards
    **/
    public function displayTimecards($timecards){
    	// only do printing here - timecards retrieved elsewhere 
    	// - to display just the student's current time card
    	// displayTimecards(list($currTimecard))
    }



}



?>