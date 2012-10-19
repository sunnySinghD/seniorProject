<?php
include_once('Hours.php');
include_once('History.php');
include_once('Student.php');
include_once('Supervisor.php');
include_once('Administrator.php');
include_once('Bookkeeper.php');
include_once('User.php');

class CardDBHelper
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
	

	// approve hour set for a user associated with a certain date
	public function approveHours($username, $date){
		$this->connect();
		// set value to approved
		$sql="UPDATE hours SET Approved=1 WHERE User='$username' AND Date='$date'";
		$result = mysql_query($sql);
		return $result;
	}
	
	// get a timecard associated with the given username and date
	public function getTimecards($username, $date){
		$this->connect();
		$sql="SELECT * FROM hours WHERE Date='$date' AND User='$username'";
		$result = mysql_query($sql);
		if (!$result){
			die('Error: ' . mysql_error());
		}
		return $result;
	}
	
	// get all hour sets associated with the given usrname and date
	public function getTimecardForDate($username, $date){

		$this->connect();
		$sql="SELECT * FROM hours WHERE Date='$date' AND User='$username'";
		$result = mysql_query($sql) or die('Error: ' . mysql_error());
		// array to fill with results
		$hours = array();
		
		$size=mysql_numrows($result);

		for($i=0; $i<$size; $i++){
			// get hour information from database result
			$id = mysql_result($result, $i, 'Id');
			$start = mysql_result($result, $i, 'Start');
			$end = mysql_result($result, $i, 'End');
			$task = mysql_result($result, $i, 'Task');
			$status = mysql_result($result, $i, 'Status');
			// construct a new hours object using that information
			$h = new Hours($username, $date, $start, $end, $task, $status);
			$h->id = $id;
			// add new object to array
			$hours[] = $h;
		}

		return $hours;

	}
	
	// retrieve the next id to assign to a new set of hours
	public function newID(){
		$sql ="SELECT max(ID) FROM hours";
		$result = mysql_query($sql) or die ('Error: ' . mysql_error());
		$row = mysql_fetch_array($result);
		if ($row[0]){return $row[0];}
		else {return 0;}
	}
	
	// retrieve the set of hours associated with a certain id
	public function getHourById($hourID){
		$this->connect();

		$sql="SELECT * FROM hours WHERE Id='$hourID'";
		$result = mysql_query($sql);	
		if (mysql_num_rows($result) < 1){
			
			return $hour = null;
		}
		// extract the variables from the result of the database
		$row = mysql_fetch_assoc($result);
		$Start = $row['Start'];
		$End = $row['End'];
		$date = $row['Date'];
		$user = $row['User'];
		$id = $row['Id'];
		$task = $row['Task'];
		$status = $row['Status'];
		
		// construct and return the hour set, using the extracted information
		$hour = new Hours($user, $date, $Start, $End, $task, $status);
		$hour->id = $id;
		
		return $hour;
		
	}
	
	// write a set of hours to the database
	public function writeHours($hours){
		$this->connect();
		// fix any problems with characters in the string that would mess up storage in th
		//   database (i.e., apostrophes)
		$hours->status = mysql_real_escape_string($hours->status);
		// extract the information from the hours object and write
		//   it to the database
		$sql="INSERT INTO hours (User, Date, Start, End, Task, Status) VALUES ('$hours->username','$hours->date', '$hours->start', '$hours->end', '$hours->task','$hours->status')";
		$result = mysql_query($sql);	
		if (!$result){
			die('Error: ' . mysql_error());
		}
		return $this->newID();
	}
	
	// delete hours from the database
	public function deleteHours($hours){
		$this->connect();
		// locate and remove the correct set of hours
		$sql= "DELETE FROM `DB475`.`hours` WHERE `hours`.`Id` = '$hours->id'";
		$result = mysql_query($sql);	
		if (!$result){
			die('Error: ' . mysql_error());
		}
	}
	
	// retrieve the tasks from the list in the database
	public function getTasks(){
		// make an array for returning the tasks (in string form)
		$tasks = array();
		
		$this->connect();
		$sql = "SELECT * FROM `tasks`";
		$result=mysql_Query($sql);
		// fill the array from the tasks table, and return it
		while($row = mysql_fetch_array($result)) {
			$tasks[] = $row['Task'];
		}
		return $tasks;
	}
	
	// add the given task to the list in the database
	public function addTask($task){
		//connect
		$this->connect();
		// insert the task
		$task = ltrim($task);
		if (strcmp($task, "") != 0){
			$sql="INSERT INTO tasks (Task) VALUES ('$task')";
			$result = mysql_query($sql);	
			if (!$result){
				die('Error: ' . mysql_error());
			}
		}
	}
	
	// remove the given task from the list in the database
	public function removeTask($task){
		//connect
		$this->connect();
		// remove task
		$sql = "DELETE FROM tasks WHERE Task = '$task'";
		$result = mysql_query($sql);
		if (!$result){
			die('Error: ' . mysql_error());
		}
	}
}

?>