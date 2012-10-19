<?php
header( 'Location: ../index.php' );

include_once('../Classes/User.php');
include_once('../Classes/Student.php');
include_once('../Classes/Supervisor.php');
include_once('../Classes/Bookkeeper.php');
include_once('../Classes/Administrator.php');
include_once('../Classes/UserDBHelper.php');
@session_start();

// get user input
$username = $_POST['Username'];
$password = $_POST['Password'];

// if input is proper
if ($username && $password)
{
	// check with authentication db that username and password are correct
	$UserDBHelper = new UserDBHelper("AUTHDB", "");
	$username = $UserDBHelper->validateLogin($username, $password);
	
	// if correct, create a new user and pass on through session
	if($username){
		$db = new UserDBHelper();
		$_SESSION['User'] = serialize($db->getUser($username));
	}
	else{
	    die("Incorrect Login");
	}
}
else{
    die("Please enter a username and password");
	}

?>
