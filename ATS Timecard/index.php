<?php 

include_once('Classes/User.php');
include_once('Classes/Student.php');
include_once('Classes/Supervisor.php');
include_once('Classes/Bookkeeper.php');
include_once('Classes/Administrator.php');

@session_start();
$user = unserialize($_SESSION['User']);
if (!$user){echo '<META HTTP-EQUIV="refresh" content="0; url=logout.php">'; die(); }
if (get_class($user) == "Supervisor"){
header('Location: view_student_timecard.php');
}
if(get_class($user) == "Student"){
header('Location: log_hours.php');
}
if(get_class($user) == "Administrator"){
header('Location: view_history.php');
}
if(get_class($user) == "Bookkeeper"){
header('Location: bookkeeping.php');
}

?>
