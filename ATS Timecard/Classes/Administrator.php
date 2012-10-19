<?php


class Administrator extends User
{

	// the user's type - easier way than referencing class
	public $type = "Administrator";

	// constructor for admin
	function __construct($username, $firstName, $lastName) {
		// set up internal variables
		$this->username = $username;
		$this->fName = $firstName;
		$this->lName = $lastName;   
		$this->UserDBHelper = new UserDBHelper();
		$this->permissions = array();
		
		// set an array containing all of the types of users an admin
		//   should have access to
		$this->editableUserTypes = array();
		array_push($this->editableUserTypes, "Student");
		array_push($this->editableUserTypes, "Bookkeeper");
		array_push($this->editableUserTypes, "Administrator");
		array_push($this->editableUserTypes, "Supervisor");
	   
		// get the names of the users of the related types
		$this->permissions = $this->UserDBHelper->getUsersOfTypes($this->editableUserTypes);

	}
	// get more complete form of history
	public function getHistory($username="this") {
		if ($username=="this") return $this->UserDBHelper->getHistory("*");
		else return $this->UserDBHelper->getHistory($username);
	}
}

?>