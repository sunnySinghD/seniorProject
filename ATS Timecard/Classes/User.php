<?php

include_once 'UserDBHelper.php';

class User
{

    //The Database Helper to perform all database actions.
    public $UserDBHelper;
	
	//Variable for easy access to user's type (without direct use of classname)
	public $type;

    //The User's first name
    public $fName = "";

    //The user's last name
    public $lName = "";

    //The user's username. Used to identify the user on the timecard system
    public $username="";
	
	// The department the user is associated with
    public $department="";
	
	// list of users (by username) that the user can access
	//   (view hours for, edit, etc.)
	public $permissions;
	
	// Types of users that the particular user can edit and create
	public $editableUserTypes;

	// constructor for a default user
   function __construct($username) {       
       $this->username = $username;
       $this->UserDBHelper = new UserDBHelper();  
   }
    
	// All users can log in 
    public function login($username){
		// call database helper function for returning appropriate user object
		return $this->UserDBHelper->getUser($username);	
	}
	
	// All user objects capable of writing/adding themselves to the database
	public function addSelf($type){
		$this->UserDBHelper->addUser($this, $type);
	}
	
	// All user objects are capable of removing themselve from the database
	public function removeSelf(){
		$this->UserDBHelper->removeUser($this);
		$this->UserDBHelper->removeRelations($this->username);
	}
	
	// All user objects can write changes to themselves (including types)
	//   back to the database
	public function editSelf($type){
		$this->UserDBHelper->editUser($this, $type);
	}
	
	// add the new user to the permissions of current user, 
	//   and add the new user - supervisor relation to the
	//   database storage
	public function addRelations($user, $supervisor){
		$this->permissions[] = $user;
		$this->UserDBHelper->addRelation($user, $supervisor);
	}
	
	// remove the associated user from the permissions array of the
	//  current user
	public function removePermissions($username){
		unset($this->permissions[array_search($username,$this->permissions)]);
	}
	
	// retrieve the list of users to which the user has access too
	// optional parameter to sort the list by
	public function getPermissions($sort="lName"){
		$users = $this->UserDBHelper->getUsers($this->permissions, $sort);
		return $users;
	}
	
	// fast way of retrieving usernames for all users of certain types
	public function getUsernames($types){
		return $this->UserDBHelper->getUsersOfTypes($types);
	}

	// All users can write new history 
	public function writeHistory($history) {
	        return $this->UserDBHelper->writeHistory($history);
	}

	// return the history associated with the user
	public function getHistory($username="this"){
	       if ($username=="this") return $this->UserDBHelper->getHistory($this->username);
	       else return $this->UserDBHelper->getHistory($username);
	}
}


?>