<?php


session_start();

header( 'Location: index.php' );

$username = $_POST['Username'];
$password = $_POST['Password'];

if ($username && $password)
{
	
	$connect = mysql_connect("localhost", "root", "") or die("Couldn't connect");
	mysql_select_db("AUTHDB") or die("Couldn't find db");
	
	$query = mysql_query("SELECT * FROM users WHERE Username='$username'");
	
	$numrows = mysql_num_rows($query);
	
	if ($numrows != 0)
	{ 
	    while ($row = mysql_fetch_assoc($query))
	    {
			$dbpassword = $row['Password'];
	    }
		
	    // check to see if they match!
	    if ($password == $dbpassword)
	    {   include_once('variables/User.php');
			include_once('variables/Student.php');
			include_once('variables/Supervisor.php');
			include_once('variables/Bookkeeper.php');
			include_once('variables/Administrator.php');
			
			
			mysql_select_db("DB475") or die("Couldn't find db");
			$sql = "SELECT * FROM users WHERE Username='$username'";
			$result=mysql_Query($sql);

	  		if (mysql_num_rows($result)!=0) {
	        	$type = mysql_result($result, 0, 'Type');
	  		}
	  		if($type == "Student"){ 
				$_SESSION['User'] = serialize(new Student($username));
	  		}
	    	else if ($type == "Supervisor"){
	  			$_SESSION['User'] = serialize(new Supervisor($username));
	  		}
	    	else if ($type == "Administrator"){
	  			$_SESSION['User'] = serialize(new Administrator($username));
	  		}
	    	 else if ($type == "Bookkeeper"){
	  			$_SESSION['User'] = serialize(new Bookkeeper($username));
	  		}

	    }
	    else
			echo "Incorrect password!";
	}
	else
	    die("That user doesn't exist");
	
	}
else
    die("Please enter a username and password");

$user = unserialize($_SESSION['User']);

echo "testing\n";
echo $user->username;

?>
