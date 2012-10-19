<?php

include_once('Classes/User.php');
include_once('Classes/Student.php');
include_once('Classes/Supervisor.php');
include_once('Classes/Bookkeeper.php');
include_once('Classes/Administrator.php');
include_once('Classes/Page.php');
include_once('Classes/UserDBHelper.php');
include_once('Classes/TimeHelper.php');
include_once('Classes/Timecard.php');

@session_start();
$user = unserialize($_SESSION['User']);
if (!(get_class($user) == "Supervisor" || get_class($user) == "Administrator"  || get_class($user) == "Bookkeeper")){
	echo '<META HTTP-EQUIV="refresh" content="0; url=logout.php">'; die();
}


$page = new Page("View Hours");

$UserDBHelper = new UserDBHelper();
$students= $user->UserDBHelper->getRelations($user->username);

$time = new TimeHelper();


$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'fName';




?>

<table id="studentTable">
	<tr>
		<th><a href='sort.php?sort=FirstName'>First Name</a></th>
		<th><a href='sort.php?sort=LastName'>Last Name</a> </th>
		<th><a href='sort.php?sort=Username'>Username</a> </th>
	</tr>
	
	<?php 
	
	foreach ($students as $stud){
		echo "<tr>";
		echo "<td>". $stud->fName . "</td>";
		echo "<td>". $stud->lName . "</td>";
		echo "<td>". $stud->username . "</td>";
		echo "</tr>";
	}
	
	?>
	

</table>