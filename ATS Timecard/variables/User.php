<?php
include_once 'variables/DBHelper.php';

class User
{

    //The Database Helper to perform all database actions.
    public $DBHelper;

    //The User's first name
    public $fName = "";

    //The user's last name
    public $lName = "";

    //The user's username. Used to identify the user on the timecard system
    public $userName="";

    //The User's email address
    public $email = "";

   function __construct($userName) {
       print "Constructing User";
       
       $this->userName = $userName;
       $this->DBHelper = new DBHelper();
       
   }
    
    
    
    
	    /**
    * login:
    *
    * @param $username The username to submit for authentication
    * @param $password The password to submit for authentication
    *
    */
    public function validate_login($username, $password){}

        //connect to university system and authenticate information
		//university system returns a name    }
    // Requires that all classes extending user have this defined
    //abstract protected function default_view();
    
    public function login($username){
    	
    	// retrieve user information from database 
    	$DBHelper->connect();
	$result = $DBHelper->getUserInfor($username);
	$User = new User();
		/*
		if($row->Type == "Student"){
			$User = new Student($row);	
		}
		else if($row->Type == "Supervisor"){
			$User = new Supervisor($row);
		}
		else if($row->Type == "Bookkeeper"){
			$User = new Bookkeeper($row);
		}
		else if($row->Type == "Admin"){
			$User = new Admin($row);
		}

		// call the default view function
		*/		
	}
	/* Function for adding a user - later, will be edited so that a 
		user adds themselves, when told to by administrator or
		supervisor functions */
	public function addUser($username, $type){
		$this->DBHelper->addUser($username, $type);
	}
	/* Function for removing a user - later, will be edited so that a 
		user removes themselves, when told to by administrator or
		supervisor functions */
	public function removeUser($username){
		$this->DBHelper->removeUser($username);
	}
	/* Function for editing a user - later, will be edited so that a 
		user edits themselves, when told to by administrator or
		supervisor functions (or even a function of their own)*/
	public function editUser($username, $type){
		$this->DBHelper->editUser($username, $type);
	}
}


?>