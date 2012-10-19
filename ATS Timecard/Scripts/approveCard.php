<?php
header( 'Location: ../view_student_timecard.php' ) ;

include_once('../Classes/User.php');
include_once('../Classes/Student.php');
include_once('../Classes/Supervisor.php');
include_once('../Classes/Bookkeeper.php');
include_once('../Classes/Administrator.php');
include_once('../Classes/Hours.php');
include_once('../Classes/Timecard.php');

@session_start();
$user = unserialize($_SESSION['User']);

if(isset($_POST['timeCard'])){
	$decode = base64_decode($_POST['timeCard']);
	$timeCard = unserialize($decode);
}

$_SESSION['StudentUsername'] = $timeCard->username;
$_SESSION['date'] = $timeCard->days[0]->date;

// set status of all hours in group to approved, and write to database
foreach($timeCard->days as $day){foreach($day->hours as $hour){$hour->status = "Approved"; $hour->write();}}

//create history and add history to database
$firstDay = $timeCard->days[0];
$history = new History($user->username, "Approved <i>$timeCard->username</i> time card for the week of <i>$firstDay->date</i>.");
$user->writeHistory($history);
$history = new History($timeCard->username, "Time card for the week of <i>$firstDay->date</i> has been Approved.");
$user->writeHistory($history);


?>