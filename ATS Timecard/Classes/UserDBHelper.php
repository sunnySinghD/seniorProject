<?php
include_once('Hours.php');
include_once('History.php');
include_once('Student.php');
include_once('Supervisor.php');
include_once('Administrator.php');
include_once('Bookkeeper.php');
include_once('User.php');

class UserDBHelper
{
	// database information
    private $name;
    private $password;

    const server = "localhost";
    const username = "root";

	// constructor for database helper
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
	
	// validate the user login information
	public function validateLogin($username, $password){
		//connect to the database
		$this->connect();
		// retrieve the associated user information from the database
		$sql = "SELECT * FROM users WHERE Username='$username'";
		$result = mysql_query($sql) or die('Error: ' . mysql_error());
		// if the information was found
		if ($result)
		{
			$dbpassword = mysql_result($result, 0, 'Password');
			// if the password matches the expected, accept the login,
			//   and return the username
			if ($password == $dbpassword){
				return $username;
			}
		}
		return "";
	}

	// Bubble sort an array of users by a given parameter of User object
	public function sort($users, $param){
	       for ( $i = 0; $i < sizeof($users); $i++ )  {  
   	       	  for ($j = 0; $j < sizeof($users); $j++ )  {  
      		     if ($users[$i]->$param < $users[$j]->$param)  {  
         	     	$temp = $users[$i];  
         		$users[$i] = $users[$j];  
         		$users[$j] = $temp;  
      		     }  
   		  }  
		} 
		return $users;
  	}

	// retrieve a user object for each element in a set of usernames
	// optional parameter to sort the list by
	public function getUsers($usernames,$sort="lName"){
		$this->connect();
		$users = array();
		// retrieve a user and add it to the result for each
		//   element in the argument array
		foreach($usernames as $name){
			$user = $this->getUser($name);
			array_push($users, $user);
		}
		return $this->sort($users, $sort);
	}
	
	// construct a user object from the database
	//   using the username as the argument
	public function getUser($username ){
		// default return value
		$user = null;
		
		$this->connect();
		// retrieve the information for the correct user from the database
		$sql="SELECT * FROM users WHERE Username='$username'";
		$result = mysql_query($sql) or die('Error: ' . mysql_error());
		$num = mysql_numrows($result);
		// if a result was returned
	    if ($num != 0) {
			// get the variables from the result
			$username = mysql_result($result, 0, 'Username');
			$type = mysql_result($result, 0, 'Type');
			$firstName = mysql_result($result, 0, 'FirstName');
			$lastName = mysql_result($result, 0, 'LastName');
		
			// construct a user of the appropriate type, and return them
			if($type == "Student"){
				$user = new Student($username, $firstName, $lastName);
			}
			else if($type == "Supervisor"){
				$user = new Supervisor($username, $firstName, $lastName);
			}
			else if($type == "Bookkeeper"){
				$user = new Bookkeeper($username, $firstName, $lastName);
			}
			else if($type == "Administrator"){
				$user = new Administrator($username, $firstName, $lastName);
			}
		}
	return $user;
	}
    	
	// add a new user to the database
    public function addUser($user, $type){	
		$this->connect();
		// fix any problems with characters in the string that would mess up storage in th
		//   database (i.e., apostrophes)
		$user->fName = mysql_real_escape_string($user->fName);
		$user->lName = mysql_real_escape_string($user->lName);
		// put the values contained in the user object into the database
		$sql = "INSERT INTO users (Type, Username, FirstName, LastName) 
			VALUES ('$type','$user->username','$user->fName','$user->lName')";
		$result = mysql_query($sql);	
		if (!$result){
			die('Error: ' . mysql_error());
		}
	}

	// remove the specified user from the database
	public function removeUser($user){
		$this->connect();
		// find and remove the correct user from the database
		$sql = "DELETE FROM users WHERE Username = '$user->username'";
		$result = mysql_query($sql);
		if (!$result){
			die('Error: ' . mysql_error());
		}
	}
	
	// edit the information (and possibly type) of the given user
	public function editUser($user,$type){
		$this->connect();
		// set all of the information stored in the database for the given
		//   user to be the information stored in the user object
		$sql = "UPDATE users SET Type='$type',FirstName='$user->fName',
		LastName='$user->lName' WHERE Username='$user->username'";
		$user->type=$type;
		$result = mysql_query($sql);
		if (!$result){
			die('Error: ' . mysql_error());
		}
	}
	
	// retrieve names of all users with type matching an element
	//   in the argument array
	public function getUsersOfTypes($types){
		$users = array();
		$this->connect();
		foreach($types as $type){
			// get all users of the type being considered from database
			$sql="SELECT * from users WHERE Type='$type'";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)) {
				$username = $row['Username'];
				// add the username of the user to the result array
				$users[] = $username;
			}
		}
	return $users;
}
	// return user objects for all users the given user is related
	//  to (responsible for) in the database
	public function getRelations($username){	
		$users = array();
		
		$this->connect();
		$sql="SELECT * FROM userRelations WHERE Username='$username' ORDER BY 'LastName' ASC";
		$result = mysql_query($sql) or die('Error: ' . mysql_error());
		$size=mysql_numrows($result);
		// make a user object for each row in result and add to
		//   result array
		for($i=0; $i<$size; $i++){
			$name = mysql_result($result, $i, 'RelateTo');
			$user = $this->getUser($name);
			array_push($users, $user);
		}
		
		return $users;
	}
	
	// add a new relation between the user and the supervisor
	//    to the user relation table in the database
	public function addRelation($user, $supervisor){
		$this->connect();
		// check if the relation already exists in the database
		//   (don't want to add duplicates)
		$sql="SELECT * FROM userRelations WHERE Username='$supervisor' AND RelateTo='$user->username'";
		$result = mysql_query($sql);
		$num = mysql_numrows($result);
		// if relation does not already exist, add it
	    if ($num == 0) {
			$sql="INSERT INTO userRelations (Username, RelateTo) VALUES ('$supervisor', '$user->username')";
			$result = mysql_query($sql) or die('Error: ' . mysql_error());
		}
	}
	
	// remove all relations connected to a specific username
	//   (for use when a user is deleted)
	public function removeRelations($username){
		$this->connect();
		// delete relations referencing the user
		$sql="DELETE FROM userRelations WHERE Username = '$username' OR RelateTo = '$username'";
		$result = mysql_query($sql) or die('Error: ' . mysql_error());
	}
	
	// remove a specific relation connection from the database
	//    removes only one relation - where higherUser (supervisor
	//    or bookkeeper) is associated with student
	public function removeRelation($higherUser, $student){
		$this->connect();
		$sql="DELETE FROM userRelations WHERE Username='$higherUser' AND RelateTo='$student'";
		$result = mysql_query($sql) or die('Error: ' . mysql_error());
	}

	// Retreives history for given username or all history if not given an input
	// Returns an array of historys
	public function getHistory($username="*") {
	    $log = array();
	    $this->connect();
	    // Return all user history for admins
	    if ($username=="*"){ 
	        $sql="SELECT * FROM history";
	    }
	    else {
	        $sql="SELECT * FROM history WHERE User='$username'";
	    }
	    $result = mysql_query($sql);
	    if (!$result){
	       die('Error: ' . mysql_error());
	    }
	    $num = mysql_numrows($result);
	    if ($num != 0) {
	        for($i=0;$i<$num || $i<1;$i++){
		    $username = mysql_result($result, $i, 'User');
		    $date = mysql_result($result, $i, 'Date');
		    $time = mysql_result($result, $i, 'Time');
		    $description = mysql_result($result, $i, 'Description');  
		    array_push($log, new History($username,$description,$date,$time));
		}
	    }
	    return $log;
	}

	// Writes a given history to the database
	public function writeHistory($history){
		$this->connect();
		// do any cleaning for strings (apostrophes, etc.)
		$history->description = mysql_real_escape_string($history->description);
		$sql="INSERT INTO history (User, Date, Time, Description) VALUES ('$history->username','$history->date', '$history->time', '$history->description')";
		$result = mysql_query($sql);	
		if (!$result){
			die('Error: ' . mysql_error());
		}
		
		//return true if it was written
		return true;
	}
	
}

?>