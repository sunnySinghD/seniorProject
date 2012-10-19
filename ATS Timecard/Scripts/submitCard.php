<?php
header( 'Location: ../view_timecard.php' ) ;

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

$_SESSION['date'] = $timeCard->days[0]->date;

//change the status of the timecards and write the change back to the database
foreach($timeCard->days as $day){foreach($day->hours as $hour){$hour->status = "Submitted"; $hour->write();}}

//create history and add history to database
$firstDay = $timeCard->days[0];
$history = new History($user->username, "Submitted time card for the week of <i>$firstDay->date</i>.");
$user->writeHistory($history);


?>