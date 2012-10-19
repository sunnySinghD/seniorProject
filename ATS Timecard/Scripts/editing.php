<?php
header('Location: ../view_users.php');
include_once('../Classes/User.php');
include_once('../Classes/Student.php');
include_once('../Classes/Supervisor.php');
include_once('../Classes/Bookkeeper.php');
include_once('../Classes/Administrator.php');
include_once('../Classes/Hours.php');
@session_start();
$user = unserialize($_SESSION['User']);

// retrieve user input
$username = $_POST['User'];
$type = $_POST['Type'];
$lname = $_POST['lname'];
$fname = $_POST['fname'];

if ($username && $type)
{
	$db = new UserDBHelper();
	// create a new user object
	$newUser = $db->getUser($username);
	// if the user input new name information, make changes
	if($lname){
		$newUser->lName = $lname;
	}
	if($fname){
		$newUser->fName = $fname;
	}
	// send the user object to change the information in the database -
	//   includes setting its type to type
	$newUser->editSelf($type);
	$message = "User '$username' made a '$type'";
	$_SESSION['message'] = $message;
	
	//create history and add history to database
	$history = new History($user->username, "Changed user permissions of <i>$username</i> to $type.");
	$user->writeHistory($history);
}
?>