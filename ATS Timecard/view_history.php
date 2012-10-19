<?php 
include_once('Classes/Page.php');
include_once('Classes/User.php');
include_once('Classes/Student.php');
include_once('Classes/Supervisor.php');
include_once('Classes/Bookkeeper.php');
include_once('Classes/Administrator.php'); 
include_once('Classes/TimeHelper.php');
$page = new Page("History");

@session_start();
$user = unserialize($_SESSION['User']);

$users = $user->getPermissions();

if (isset($_POST['Username'])){ $historyUsername = $_POST['Username'];}
else if (isset($_SESSION['HistoryUsername'])){ $historyUsername = $_SESSION['HistoryUsername'];}
else $historyUsername = "All";

if (isset($_POST['lines'])) { $maxHistoryDisplay = $_POST['lines'];}
else {$maxHistoryDisplay = 8; }

$time = new TimeHelper();
if (isset($_POST['day'])) { $day = $_POST['day']; }
else $day = "--/--/--";

if (isset($_POST['week'])) { $week = $_POST['week']; }
else $week = $time->firstDayOfWeek(date("m/d/y"));

if (isset($_POST['date'])) { $date = $_POST['date']; }
else if (isset($_POST['week'])) { $date = $_POST['week']; }
else $date = $time->firstDayOfWeek(date("m/d/y"));
?>

<h3>History</h3>

<!-- Form to select number of lines of history to show and select a specific user -->
<form action='view_history.php' method="post">
        Lines: <input type="text" name="lines" size="1" value=<?php echo $maxHistoryDisplay; ?> />&nbsp;
        User: <select name="Username">
	<option value="All">All
	<?php foreach($users as $u){ 
	      if($u->username==$historyUsername){
	          echo "<option selected='selected' value=" . $u->username .">" . $u->lName .", ". $u->fName . ' - ' .$u->username . "</option>";}
	      else {
	      	  echo "<option value=" . $u->username .">"  . $u->lName .", ". $u->fName . ' - ' .$u->username . "</option>";} 
	      }
	?>
	</select>
	<input type="hidden" name="day" value=<?php echo $day; ?> />
	<input type="submit" value = "Go"/>
</form>
<br>
<?php
if ($day != "--/--/--") echo "<u>Displaying history for the day of ".$day."</u><br>";
else echo "<u>Displaying history for the week of ".$date."</u><br>";

if ($historyUsername != "All") $log = $user->getHistory($historyUsername);
else $log = $user->getHistory();

// Display in reverse so that the most recent history displays on top
$incr = 0;
while ($log & $incr < $maxHistoryDisplay) {
    $history = array_pop($log);
    // If a specific day was set, only show history for that day
    if ($day != "--/--/--" && $history->date==$day) {
       // Display the histories username for admins and supervisors
       if ($user->type=="Administrator" || $user->type=="Supervisor"){ 
       	  echo '<b>',$history->getFirstName(),' ', $history->getLastName(),'</b> '; }
       echo ' &bull; ',$history->get_date(), ' ', $history->get_time(),'&nbsp;&rarr; ', $history->get_description(), '<br>';
    }
    // Else show all history in the selected week
    else if ($week != "" && $time->inWeek($history->date, $week)) {
       // Display the histories username for admins and supervisors
       if ($user->type=="Administrator" || $user->type=="Supervisor"){ 
       	  echo '<b>',$history->getFirstName(),' ',$history->getLastName(),'</b> '; }
       echo ' &bull; ',$history->get_date(), ' ', $history->get_time(),'&nbsp;&rarr; ', $history->get_description(), '<br>';
    }
    $incr++;
}

?>


<br><br><hr>
<table id="table-clear">
<td align="left">
    <!-- Form to move to the previous week -->
    <form action="view_history.php" method="post" >
    	  <input type="hidden" name="date" value=<?php echo $time->offsetDay($date, -7)?> />
	  <input type="hidden" name="week" value=<?php echo $time->offsetDay($date, -7)?> />
	  <input type="hidden" name="Username" value="<?php echo $historyUsername?>" />
	  <input type="submit" value="Previous"/> 
    </form>	
</td>

<td align="right">
    <!-- Form to select a specific date -->
    <form action="view_history.php" method="post" >
	  <font size=2>Day: </font>
	  <input type="hidden" name="Username" value="<?php echo $historyUsername?>" />
	  <input type="hidden" name="week" value="" />
	  <input name="day" type="text" value=<?php echo $day;?>>
	  <input type="hidden" name="date" value=<?php echo $date;?>>
	  <input type="submit" value="Go"/> 
    </form>
</td>

<td align="left">
    <!-- Form to select a week -->
    <form action="view_history.php" method="post" >
    	  <font size=2>Week:</font>
	  <select name="week">
	  <?php
	  $weeks = $time->weeksOfYear();
	  $len= count($weeks);
	  for($i=0;$i<$len;$i++){
		if ($weeks[$i]==$date){
		   echo '<option selected="selected" value="' . $weeks[$i] .'">'.$weeks[$i].'</option>';}
		else {echo '<option value="' . $weeks[$i] .'">'.$weeks[$i].'</option>';}
	  }
	  ?>
	  </select>
	  <input type="hidden" name="Username" value="<?php echo $historyUsername?>" />
	  <input type="submit" value="Go"/> 
    </form>
</td>

<td align="right">
    <!-- Form to move to the next week -->
    <form action="view_history.php" method="post" >
	  <input type="hidden" name="date" value=<?php echo $time->offsetDay($date, 7)?> />
	  <input type="hidden" name="week" value=<?php echo $time->offsetDay($date, 7)?> />
	  <input type="hidden" name="Username" value="<?php echo $historyUsername?>" />
	  <input type="submit" value="Next"/> 
    </form>
</td>
</table>

<?php $page->include_footer() ?>