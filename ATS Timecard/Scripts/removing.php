<?php
header('Location: ../view_users.php');
include_once('../Classes/User.php');
include_once('../Classes/Student.php');
include_once('../Classes/Supervisor.php');
include_once('../Classes/Bookkeeper.php');
include_once('../Classes/Administrator.php');
include_once('../Classes/Hours.php');
include_once('../Classes/UserDBHelper.php');

@session_start();

// retrieve user object and user input
$user = unserialize($_SESSION['User']);
$username = $_POST['Username'];
echo $username;
// if a username is passed
if ($username){
	$db = new UserDBHelper();
	// make a new user object
	$newUser = $db->getUser($username);
	// some input checking will go here - user should not remove self
	// have the object remove itself
	$newUser->removeSelf();
	// remove the permissions associated with the removed user
	$user->removePermissions($newUser->username);
	$message = "User $username removed";
	$_SESSION['message'] = $message;
	// save the altered user
	$_SESSION['User'] = serialize($user);

	//create history and add history to database
	$history = new History($user->username, "Removed user <i>$username</i> from database.");
	$user->writeHistory($history);
}
?>