<!--backend php script for removing users-->

<?php
include('variables/User.php');
session_start();
header('Location: viewUsers.php');
$user = new User();

// get user input for username
$username = $_POST['Username'];

if ($username)
{
	// some input checking will go here

	// call method for removing user in php class user
	$user->removeUser($username);
	// create appropriate message for display to user
	$message = "User $username removed";
	$_SESSION['message'] = $message;

}
?>