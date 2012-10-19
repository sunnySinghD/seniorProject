<?php
header( 'Location: ../manage_supervision.php' );
include_once('../Classes/User.php');
include_once('../Classes/Student.php');
include_once('../Classes/Supervisor.php');
include_once('../Classes/Bookkeeper.php');
include_once('../Classes/Administrator.php');
include_once('../Classes/Hours.php');
include_once('../Classes/UserDBHelper.php');


@session_start();
$user = unserialize($_SESSION['User']);

// add the specified relation to the database
$higherUser = $_POST['superORbook'];
$stud = $_POST['Student'];
$db = new UserDBHelper();
$db->addRelation($db->getUser($stud), $higherUser);

//create history and add history to database
$history = new History($user->username, "User <i>$_POST[superORbook]</i> now monitors <i>$_POST[Student]</i>.");
$history->write();


?>