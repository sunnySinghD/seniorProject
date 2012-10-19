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

$decode = base64_decode($_POST['hours']);
$hours = unserialize($decode);

$hours->clear();

$time = new TimeHelper();
$_SESSION['date'] = $time->firstDayOfWeek($hours->date);


//create and add history to database
$history = new History($user->username, "Deleted work hours for <i>$hours->date</i>");
$history->write();

?>