<?php


class Supervisor extends User
{
	// the user's type - easier way than referencing class
	public $type = "Supervisor";
	
	// constructor for supervisor
	function __construct($username, $firstName, $lastName) {
		// sets the student's username, first name, and last name accordingly
		$this->username = $username;
		$this->fName = $firstName;
		$this->lName = $lastName; 

		// creates a UserDBHelper for the student to make use of
		$this->UserDBHelper = new UserDBHelper();
		
		// set an array containing all of the types of users an supervisor
		//   should have access to
		$this->editableUserTypes = array();
		array_push($this->editableUserTypes, "Student");
		
		// set the permission array for the supervisor - the list of
		//   students they will be able to access
		$this->permissions = array();
		// use the database helper to get all the students the supervisor
		//   is associated with, and add them to the permissions array
		foreach ($this->UserDBHelper->getRelations($username) as $user){
			array_push($this->permissions, $user->username);
		}
		// user has permission to access themselves
		array_push($this->permissions, $this->username);
   }

   public function getHistory($username="this"){
   	  $history = $this->UserDBHelper->getHistory($this->username);
	  $students = $this->getPermissions();
	  foreach ($students as $student) {
		if($student->type == "Student"){
	  	  $studHistory = $student->getHistory();
		  foreach ($studHistory as $line) {
		  	  array_push($history, $line);
		  }
		}
	  }
	  if ($username=="this") return $this->sortHistory($history);
	  else return $this->UserDBHelper->getHistory($username);
   }

   private function sortHistory($history){
   	   for ( $i = 0; $i < sizeof($history); $i++ )  {  
   	       	  for ($j = 0; $j < sizeof($history); $j++ )  {  
      		     if ($history[$i]->date < $history[$j]->date)  {  
         	     	$temp = $history[$i];  
         		$history[$i] = $history[$j];  
         		$history[$j] = $temp;  
      		     }  
   		  }  
	   }
	   for ( $i = 0; $i < sizeof($history); $i++ )  {  
   	       	  for ($j = 0; $j < sizeof($history); $j++ )  {  
		     if ($history[$i]->date == $history[$j]->date){
      		     if ($history[$i]->time < $history[$j]->time)  {  
         	     	$temp = $history[$i];  
         		$history[$i] = $history[$j];  
         		$history[$j] = $temp;  
      		     }  	    
		     }
   		  }  
	   }  
	   return $history;
   }	
}

?>