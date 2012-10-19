<?php 
include_once('variables/User.php');
include_once('variables/Student.php');
include_once('variables/Supervisor.php');
include_once('variables/Bookkeeper.php');
include_once('variables/Administrator.php');

session_start();
$user = unserialize($_SESSION['User']);

if (get_class($user) == "Supervisor"){
	echo "yaaaaaaaaay";
	$user = new Supervisor($user->username);
}
if(get_class($user) == "Administrator"){
	$user = new Administrator($user->username);
}
else{
	
	//logout if neither
	echo '<META HTTP-EQUIV="refresh" content="0; url=logout.php">'; die();
	
}


include('variables/Page.php');
$page = new Page("Edit User");

include_once('variables/DBHelper.php');
$dbHelper = new DBHelper("DB475", "");
$dbHelper->connect();


echo "hello there supervisor";


$listOfStudents = $user.getListOfStudents();




?>

