<!--Backend script for adding a new user to the system-->

<?php
header('Location: viewUsers.php');

include('variables/User.php');

session_start();
$user = new User();

// get user input for usesrname and type
$username = $_POST['username'];
$type = $_POST['Type'];

if ($username && $type)
{
	// some input checking will go here

	//interact with the user php class - send a message to add user
	$user->addUser($username, $type);

	// set a meaningful message to be displayed for the user
	$message = "User '$username' added";
	$_SESSION['message'] = $message;
}
?>