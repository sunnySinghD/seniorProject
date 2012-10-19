<?php 
include_once('Classes/User.php');
include_once('Classes/Student.php');
include_once('Classes/Supervisor.php');
include_once('Classes/Bookkeeper.php');
include_once('Classes/Administrator.php');
include_once('Classes/CardDBHelper.php');
include_once('Classes/TimeHelper.php');
include_once('Classes/Page.php');

@session_start();
$user = unserialize($_SESSION['User']);
if (!(get_class($user) == "Student")){echo '<META HTTP-EQUIV="refresh" content="0; url=logout.php">'; die(); }

// basic initialization
$page = new Page("Log Hours");

$cardDBHelper = new CardDBHelper();
$tasks = $cardDBHelper->getTasks();

$time = new TimeHelper(); 
$firstDay = $time->firstDayOfWeek(date("m/d/y"));
$lastDay = $time->offsetDay($firstDay, 6);
$days = $time->datesBetween($firstDay, $lastDay);


echo "<h3>Log Hours</h3>";

if(isset($_GET["error"])){
	$err = $_GET["error"];
	switch($err){
		case 1:
			echo "**Could not log hours. Time must be in format '1:00PM'\n"; break;
		case 2:
			echo "Timecard not open."; break;
		case 3:
			echo "**Could not log hours. Conflict in hours\n"; break;
	}
}

// If user attempted to log hours in an improper format, print
//   error message

?>

<!--Form for submitting hours-->
<form action="Scripts/submitHours.php" method="post">
    <table border="1" align="center">
    	   	<tr>
		    <th colspan='4' align='center'><?php echo  'Week of '. $firstDay;?></th>
		</tr>
		<tr>
		    <th>Date</th>
		    <th>Time in</th>
	        <th>Time out</th>
		    <th>Task</th>	
		</tr>
		
		<!--Table for logging hours-->
		<tr>
		    <td><select name="date"><?php foreach($days as $day){ echo '<option value="' . $day .'">' . date("D", strtotime($day)) .", " . $day . "</option>";}?></select></td>
			<td><input type="text" name="hoursin" /></td>
			<td><input type="text" name="hoursout" /></td>
			<td><select name="task"><?php foreach($tasks as $task){ echo '<option value="' . $task .'">' . $task . "</option>";}?></select></td>
		</tr>
    </table>
    <center><input type="submit" value="Submit"/></center>
</form>

<?php $page->include_footer(); ?>