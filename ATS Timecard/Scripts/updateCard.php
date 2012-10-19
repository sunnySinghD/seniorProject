<?php
//header( 'Location: ../view_timecard.php' ) ;
include_once('../Classes/User.php');
include_once('../Classes/Student.php');
include_once('../Classes/Supervisor.php');
include_once('../Classes/Bookkeeper.php');
include_once('../Classes/Administrator.php');
include_once('../Classes/Hours.php');
include_once('../Classes/Timecard.php');

@session_start();
$user = unserialize($_SESSION['User']);

$decode = base64_decode($_POST['hours']);
$hours = unserialize($decode);


$time = new TimeHelper();
$_SESSION['date'] = $time->firstDayOfWeek($hours->date);

$timecard = new TimeCard($user->username, $_SESSION['date']);

$hoursInValid = $time->handleTimeInput($_POST['start']);
$hoursOutValid = $time->handleTimeInput($_POST['end']);

// retrieve user input
$hours->start = $_POST['start'];
$hours->end = $_POST['end'];
$hours->task = $_POST['task'];
// write the hours to the database

if(!$time->handleTimeInput($_POST['start'])){
	//echo '<META HTTP-EQUIV="refresh" content="0; url=../view_timecard.php?error=1">';
	//echo "<br /> start input is invalid:". $_POST['start']."<br />";
	
}
if(!$time->handleTimeInput($_POST['end'])){
	//echo '<META HTTP-EQUIV="refresh" content="0; url=../view_timecard.php?error=1">';
	//echo "start input is invalid:". $_POST['ends']."<br />";
	
}


if(!$time->handleTimeInput($_POST['start']) && !$time->handleTimeInput($_POST['end'])){
	echo '<META HTTP-EQUIV="refresh" content="0; url=../view_timecard.php?error=1">';
	//echo $hours->start."\n";
}
else if($timecard->status == "Submitted" || $timecard->status == "Approved"){
	echo '<META HTTP-EQUIV="refresh" content="0; url=../view_timecard.php?error=2">';
}
/*
else if(!($time->hoursOverlap($_POST['start'], $_POST['end'], $user->username, $hours->date))){
	echo '<META HTTP-EQUIV="refresh" content="0; url=../view_timecard.php?error=3">';
}
*/

else{
	$hours->write();
	echo '<META HTTP-EQUIV="refresh" content="0; url=../view_timecard.php">';
}



//create and add history to database
$history = new History($user->username, "Edited work hours for $hours->date");
$history->write();

?>