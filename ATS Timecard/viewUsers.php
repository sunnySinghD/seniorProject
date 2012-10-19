<!--Page for viewing the users in the system-->

<?php
include_once('variables/User.php');
include_once('variables/Student.php');
include_once('variables/Supervisor.php');
include_once('variables/Bookkeeper.php');
include_once('variables/Administrator.php');

session_start();
// retrieve user object
$user = unserialize($_SESSION['User']);
// if user is not a supervisor or administrator, deny access
if (!(get_class($user) == "Supervisor" || get_class($user) == "Administrator")){echo '<META HTTP-EQUIV="refresh" content="0; url=logout.php">'; die(); }

include('variables/Page.php'); 
$page = new Page("View Users");
include_once('variables/DBHelper.php');
// connect to database
$dbHelper = new DBHelper("DB475", "");
$dbHelper->connect();
?>

<h3>View Users</h3>

<table border="1" align="center">
	<tr>
		<th> Type </th>
		<th> User </th>
	</tr>
	
	<!--Display a message (if there is one) and a table of users-->
	<?php 
	// if there is a message, display it and get rid of it
	if(isset($_SESSION['message']))
	echo $_SESSION['message'];
	unset($_SESSION['message']);

	// retrieve all users from database
	$result = $dbHelper->getAllUsers();
	$num_rows = mysql_num_rows($result);
	// if there are users to display
	if ($num_rows != 0) {
		$i = 0;
		// for each user, display their type and username
		while($i < $num_rows):
			$type = mysql_result($result, $i, 'type');
			$username = mysql_result($result, $i, 'username');
			echo "</td>";
			echo "<td align=center> $type</td>";
			echo "<td align=center>$username</td>";
			echo "</td></tr>";
			$i++;
		endwhile;
	}		
	?>
</table>


<?php $page->include_footer(); ?>

