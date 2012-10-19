<?php 
include_once('Classes/User.php');
include_once('Classes/Student.php');
include_once('Classes/Supervisor.php');
include_once('Classes/Bookkeeper.php');
include_once('Classes/Administrator.php');
include_once('Classes/CardDBHelper.php');

@session_start();
$user = unserialize($_SESSION['User']);
if (!(get_class($user) == "Supervisor" || get_class($user) == "Administrator")){echo '<META HTTP-EQUIV="refresh" content="0; url=logout.php">'; die(); }

include('Classes/Page.php');
$page = new Page("Tasks");

$cardDBHelper = new CardDBHelper();
$tasks = $cardDBHelper->getTasks();
?>

<h3>Task</h3>

<table border="1" align="center">
	<tr>
	    <th colspan=2>Tasks</th>
	</tr>
	    <?php foreach($tasks as $task){
	    	echo '<tr><td>'.$task.'</td>';
			// print the tasks to a table, with delete buttons
	    	echo "
				<td align=center>
					<form action='Scripts/deleteTask.php' method='post' >
						<input type='hidden' name='task' value='".$task."'>
			      		 <input type='submit' value='Delete'/> 
			        </form>
			   	</td></tr>";
	    }?>
    </table>

<!--Form for adding a task-->
<form action="Scripts/addTask.php" method="post">
    <table border="1" align="center">
	<tr>
	    <th>Enter a task to be added</th>
	</tr>
	<tr>
	    <td>
		<input type="text" name="task" size="50" />
	    </td>
	</tr>
    </table>
    
	<center><input type="submit"/></center>
</form>

<?php $page->include_footer(); ?>