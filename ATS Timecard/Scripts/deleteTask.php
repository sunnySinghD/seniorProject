<?php
header( 'Location: ../task.php' );
include_once('../Classes/User.php');
include_once('../Classes/Student.php');
include_once('../Classes/Supervisor.php');
include_once('../Classes/Bookkeeper.php');
include_once('../Classes/Administrator.php');
include_once('../Classes/Hours.php');
include_once('../Classes/CardDBHelper.php');


@session_start();
$user = unserialize($_SESSION['User']);

//remove the requested task
$task = $_POST['task'];
$db = new CardDBHelper();
$db->removeTask($task);

//create history and add history to database
$history = new History($user->username, "Removed task <i>$_POST[task]</i>.");
$user->writeHistory($history);

?>