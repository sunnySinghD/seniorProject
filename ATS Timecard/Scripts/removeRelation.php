<?php
header( 'Location: ../manage_supervision.php' );
include_once('../Classes/User.php');
include_once('../Classes/Student.php');
include_once('../Classes/Supervisor.php');
include_once('../Classes/Bookkeeper.php');
include_once('../Classes/Administrator.php');
include_once('../Classes/Hours.php');
include_once('../Classes/UserDBHelper.php');

ini_set('display_errors',1); 
 error_reporting(E_ALL);


@session_start();
$user = unserialize($_SESSION['User']);

// retrieve supervisor/bookkeeper and student
//   to remove an association from
$higherUser = $_POST['higherUser'];
$stud = $_POST['stud'];
$db = new UserDBHelper();

$db->removeRelation($higherUser, $stud);

//create history and add history to database
$history = new History($user->username, "Removed user <i>$_POST[higherUser]</i> from monitoring <i>$_POST[stud]</i>.");
$history->write();

?>