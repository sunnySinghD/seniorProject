<?php 
include_once('variables/User.php');
include_once('variables/Student.php');
include_once('variables/Supervisor.php');
include_once('variables/Bookkeeper.php');
include_once('variables/Administrator.php');

session_start();
$user = unserialize($_SESSION['User']);
if (!(get_class($user) == "Supervisor" || get_class($user) == "Administrator")){echo '<META HTTP-EQUIV="refresh" content="0; url=logout.php">'; die(); }

include('variables/Page.php');
$page = new Page("New Task");
?>

<!--Form for adding a task-->
<form action="addTask.php" method="post">
    <table border="1" align="center">
	<tr>
	    <th>New Task</th>
	<tr>
	    <td>
		<input type="text" name="task" size="100" />
	    </td>
	</tr>
    </table>
    
	<center><input type="submit"/></center>
</form>

<?php $page->include_footer(); ?>