<?php

include_once('../Classes/User.php');
include_once('../Classes/Student.php');
include_once('../Classes/Supervisor.php');
include_once('../Classes/Bookkeeper.php');
include_once('../Classes/Administrator.php');
include_once('../Classes/Hours.php');
include_once('../Classes/TimeHelper.php');
include_once('../Classes/Timecard.php');

@session_start();
$user = unserialize($_SESSION['User']);

$timeHelper = new TimeHelper();
//make sure the hours given are in proper time format
$hoursInValid = $timeHelper->handleTimeInput($_POST['hoursin']);
$hoursOutValid = $timeHelper->handleTimeInput($_POST['hoursout']);
$timecard = new TimeCard($user->username, $_POST['date']);


if($timecard->status == "Submitted" || $timecard->status == "Approved"){
	echo '<META HTTP-EQUIV="refresh" content="0; url=../log_hours.php?error=2">';
}
else if(!($hoursInValid && $hoursOutValid)){
	echo '<META HTTP-EQUIV="refresh" content="0; url=../log_hours.php?error=1">';
}

else if(!($hoursInValid && $hoursOutValid)){
	echo '<META HTTP-EQUIV="refresh" content="0; url=../log_hours.php?error=1">';
}

else if(!($timeHelper->hoursOverlap($_POST['hoursin'],$_POST['hoursout'], $user->username, $_POST['date']))){
	echo '<META HTTP-EQUIV="refresh" content="0; url=../view_timecard.php?error=3">';
}

else{
	//if Hours are valid, log the hours
	$h = new Hours($user->username,$_POST['date'], str_replace(" ", "", strtoupper($_POST['hoursin'])), str_replace(" ", "", strtoupper($_POST['hoursout'])), $_POST['task'], 'Open');
	$h->write();

	//create history and add history to database
	$history = new History($user->username, "Logged work hours for <i>$_POST[date]</i>.");
	$user->writeHistory($history);

	echo '<META HTTP-EQUIV="refresh" content="0; url=../view_timecard.php">';
}


?>