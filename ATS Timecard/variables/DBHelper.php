<?php

class DBHelper
{
    private $name;
    private $password;

    const server = "localhost";
    const username = "root";

    function __construct($dbName="DB475", $pass = "") {
        $this->name = $dbName;
	$this->password = $pass;
    }

	// connect to the database
    public function connect() {
        $db = mysql_connect(self::server, self::username, $this->password);
	if (!$db){
	    die('Could not connect: ' . mysql_error());
	}
	mysql_select_db($this->name, $db);
    }
    
	// get the information stored in the database for the given user
    public function getUserInfo($username) {
    	$this->connect();
    	$sql = "SELECT * FROM users WHERE Username = '$username'";
		$result = mysql_query($sql);
		$row = mysql_fetch_object($result);
		return $row;
	}
    
	// add the given user to the database
    public function addUser($username, $type){	
		$this->connect();
		$sql = "INSERT INTO users (Username, Type) VALUES ('$username', '$type')";
		$result = mysql_query($sql);	
		if (!$result){
			die('Error: ' . mysql_error());
		}
	}	

	// remove the given user from the database
	public function removeUser($username){
		$this->connect();
		$sql = "DELETE FROM users WHERE Username = '$username'";
		$result = mysql_query($sql);
		if (!$result){
			die('Error: ' . mysql_error());
		}
	}
	// change the type of the user to that submitted
	public function editUser($username, $type){
		$this->connect();
		$sql = "UPDATE users SET Type= '$type' WHERE Username='$username'";
		$result = mysql_query($sql);
		if (!result){
			die('Error: ' . mysql_error());
		}
	}
	// retrieve all users from database
	public function getAllUsers(){
		$this->connect();
		$sql="SELECT * from users";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function query($queryString){

		$this->connect();
		$sql= $queryString;
		$resul = mysql_query($sql);
		return $result;
		
	
	}
}
?>