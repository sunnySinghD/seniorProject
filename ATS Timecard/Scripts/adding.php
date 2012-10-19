<?php
@session_start();
header('Location: ../view_users.php');
include('../Classes/User.php');
include_once('../Classes/Supervisor.php');
include_once('../Classes/Administrator.php');
$user = unserialize($_SESSION['User']);

$username = $_POST['username'];
$type = $_POST['Type'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$super = $_POST['Supervisor'];

if ($username && $type && $fname && $lname)
{
	// make a new user object
	$newUser = new User($username);
	// some input checking will go here
	// set user qualities appropriately
	$newUser ->fName = $fname;
	$newUser ->lName = $lname;
	$newUser ->addSelf($type);
	if($type == "Student"){
		// add a supervisor relation for the student
		$user->addRelations($newUser, $super);
		$db = new UserDBHelper();
		$_SESSION['User'] = serialize($db->getUser($user->username));
	}
	else{ // adding user must be an admin
		// add the new user to their permissions, and save change
		$user->permissions[] = $newUser;
		$db = new UserDBHelper();
		$_SESSION['User'] = serialize($db->getUser($user->username));
	}
	$message = "User '$username' added";
	$_SESSION['message'] = $message;

	//create history and add history to database
	$history = new History($user->username, "Added user <i>$username</i> with $type permissions.");
	$user->writeHistory($history);
}
else {
	$message = "User information not properly filled in";
	$_SESSION['message'] = $message;
	}
?>