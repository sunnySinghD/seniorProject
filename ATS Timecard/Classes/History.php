<?php

include_once('UserDBHelper.php');

class History 
{
	// internal variables for the history
    public $username;
    public $date;
    public $time;
    public $description;
    public $UserDBHelper;

    // Constructs a history given a username, description, date, time
    // Date/time are defaulted to the current time if no date/time is entered
    function __construct($username, $description, $date="", $time="") {
    	date_default_timezone_set('EST');
        $this->username = $username;
		if ($date==""){
			$this->date = date("m/d/y");
		}
		else {$this->date = $date;}
		if ($time==""){
			$this->time = date("H:i:s");
		}
		else {$this->time = $time;}
		$this->description = $description;
		$this->UserDBHelper = new UserDBHelper();
    }

    public function get_description() {
    	return $this->description;
    }

    public function get_time() {
    	return $this->time;
    }

    public function get_date() {
    	return $this->date;
    }

    // Writes this history to the database
    public function write() {
    	return $this->UserDBHelper->writeHistory($this);
    }

    public function getFirstName(){
    	$user = $this->UserDBHelper->getUser($this->username);
	return $user->fName;
    }

    public function getLastName(){
    	$user = $this->UserDBHelper->getUser($this->username);
	return $user->lName;
    }

}

?>