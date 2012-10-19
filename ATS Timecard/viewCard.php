<?php
include_once('variables/User.php');
include_once('variables/Student.php');
include_once('variables/Supervisor.php');
include_once('variables/Bookkeeper.php');
include_once('variables/Administrator.php');
session_start();
$user = unserialize($_SESSION['User']);
if (!(get_class($user) == "Student")){echo '<META HTTP-EQUIV="refresh" content="0; url=logout.php">'; die(); }

include('variables/Page.php'); 
$page = new Page("Time Card");

include_once('variables/DBHelper.php');
$dbHelper = new DBHelper("DB475", "");
$dbHelper->connect();

?>

<h3>Student Time Card</h3>

<!--Determines the first day of the week-->
<?php
include('variables/TimeHelper.php');    
$time = new TimeHelper();
echo "Week of ", $time->first_day_of_week();
?>

<form action="submitCard.php" method="post">
    <table border="1" align="center">

	<tr>
	    <th> Date: </th>
	    <th> Time in: </th>
            <th> Time out: </th>
	    <th> Task: </th>	
	</tr>
	
	<!--Script for producing the entire weeks timecard-->
	<?php 
	for ($day=0;$day<=6;$day++){
	    echo "<tr><td>";
	    echo $time->int_to_day($day), ", ";

	    $currDate = $time->first_day_of_week($day);	
	    echo $currDate;
	    $sql = sprintf("SELECT * FROM `cards` WHERE `Date` = '%s'",$currDate);
	    $result=mysql_Query($sql);
	    if (mysql_num_rows($result)!=0) {
	        $hoursin = mysql_result($result, 0, 'HoursIn');} 
            else {$hoursin = "";}
	    if (mysql_num_rows($result)!=0) {
                $hoursout = mysql_result($result, 0, 'HoursOut');} 
            else {$hoursout = "";}
		if (mysql_num_rows($result)!=0) {
                $task = mysql_result($result, 0, 'Task');} 
            else {$task = "";}
		
	    echo "</td>";
	    echo "<td align=center> $hoursin</td>";
	    echo "<td align=center>$hoursout</td>";
	    echo "<td align=center>$task</td>";
	    echo "</td></tr>";
	}
	?>

    </table>
    
	<center><input type="submit"/></center>
</form>

<?php $page->include_footer(); ?>