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

if(isset($_POST['hours'])){
	$decode = base64_decode($_POST['hours']);
	$hours = unserialize($decode);
}

$page = new Page("Log Hours");

$cardDBHelper = new CardDBHelper();
$tasks = $cardDBHelper->getTasks();

$time = new TimeHelper(); 
$firstDay = $time->firstDayOfWeek(date("m/d/y"));
$lastDay = $time->offsetDay($firstDay, 6);
$days = $time->datesBetween($firstDay, $lastDay);


echo "<h3>Log Hours " . "(Week of ", $firstDay, ")" . "</h3>";

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
?>

<!--Form for submitting hours-->
<form action="Scripts/updateCard.php" method="post">
    <table border="1" align="center">
		<tr>
		    <th>Date</th>
		    <th>Time in</th>
	        <th>Time out</th>
		    <th>Task</th>	
		</tr>
		
		<!--Table for logging hours-->
		<tr>
		    <td><?php echo date("D", strtotime($hours->date)) .", ". $hours->date?></td>
			<td><input type="text" name="start" value="<?php echo $hours->start;?> "/></td>
			<td><input type="text" name="end" value="<?php echo $hours->end;?> "/></td>
			<td>
				<select name="task">
					<?php 
					foreach($tasks as $task){
						if($task==$hours->task){ 
							echo '<option selected="selected" value="' . $task .'">' . $task . "</option>";
						} else {echo '<option value="' . $task .'">' . $task . "</option>";};
					}
					?>
				</select>
			</td>
		</tr>
    </table>
    <input type="hidden" name="hours" value="<?php echo $_POST['hours'];?>"/>
    <center><input type="submit" value="Submit"/></center>
</form>

<?php $page->include_footer(); ?>