<!--Backend php script for editing users in the system-->

<?php
include('variables/User.php');
header('Location: viewUsers.php');
session_start();
$user = new User();

// get user input from previous php form
$username = $_POST['Username'];
$type = $_POST['SetToType'];

if ($username && $type)
{
	// some input checking will go here
	
	// interact with the php User class and call editUser
	$user->editUser($username, $type);
	
	// save appropriate message to be displayed for user
	$message = "User '$username' made a '$type'";
	$_SESSION['message'] = $message;
	
}
?>