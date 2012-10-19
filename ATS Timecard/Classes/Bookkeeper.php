<?php


class Bookkeeper extends User
{
	// the user's type - easier way than referencing class
	public $type = "Bookkeeper";
	
	// constructor for bookkeeper
	function __construct($username, $firstName, $lastName) {
		//set up internal variables
		$this->username = $username;
		$this->fName = $firstName;
		$this->lName = $lastName;   
		$this->UserDBHelper = new UserDBHelper();
		$this->permissions = array();
	   
		// consult the database to extract the users the bookkeeper has
		//   permission to view
		foreach ($this->UserDBHelper->getRelations($username) as $user){
			array_push($this->permissions, $user->username);
		}
		// user has permissions for themselves
		array_push($this->permissions, $this->username);
	}	
}
?>