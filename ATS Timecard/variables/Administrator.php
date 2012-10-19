<?php


class Administrator extends User
{
   function __construct($username) {
      // print "Constructing User";
       $this->username = $username;
       $this->DBHelper = new DBHelper();
   }
   
	//An array of the students to Supervise
	public $studentList = array();
	
	//View Student's Timecard
	public function viewStudentsTimecard($student, $start, $end){
		
		//Query the DB for a student's time card between &start and $end
		
		
		//Return appropriate information and print to webpage

	}
	
	/**
	 * 
	 * Approve a set of timecard entries, from start to end of the student
	 * 
	 * @param Student $student the student to approve
	 * @param date? $start	the starting timecard entry date
	 * @param date? $end	the end timecard entry date
	 */
	public function approveTimecard($student, $start, $end){
		
		//search DB for timecard
		
		//approve timecard entries from start to end
		
	}
	
	
	
}



?>