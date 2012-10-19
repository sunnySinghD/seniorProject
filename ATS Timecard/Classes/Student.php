<?php

include_once('User.php');

class Student extends User
{	
	// the user's type - easier way than referencing class
	public $type = "Student";
	// log for storing history of user
    public $log;
	
	// constructor for student
	public function __construct($username, $firstName, $lastName) {
		// sets the student's username, first name, and last name accordingly
       $this->username = $username;
	   $this->fName = $firstName;
	   $this->lName = $lastName;
	   
	   // sets the student's permissions (they should only be able to view
	   //   their own information, not that of any other user)
	   $this->permissions = array();
	   array_push($this->permissions, $username);
	   
	   // creates a DBHelper for the student to make use of
       $this->UserDBHelper = new UserDBHelper(); 
	}
}

?>