<?php 
include_once('Classes/User.php');
include_once('Classes/Student.php');
include_once('Classes/Supervisor.php');
include_once('Classes/Bookkeeper.php');
include_once('Classes/Administrator.php');
include_once('Classes/Page.php');
include_once('Classes/TimeHelper.php');
include_once('Classes/Timecard.php');
include_once('Classes/Hours.php');
include_once('Classes/Day.php');

@session_start();
$user = unserialize($_SESSION['User']);
if (!(get_class($user) == "Supervisor" || get_class($user) == "Administrator")){echo '<META HTTP-EQUIV="refresh" content="0; url=logout.php">'; die(); }


$page = new Page("View Hours");

// get the usernames of all users the current user has permission to view
$students= $user->getPermissions();

$time = new TimeHelper();

// retrieve information from previous user input
// - display if user has altered these
if (isset($_POST['Username'])){ $studentUsername = $_POST['Username'];}
else if (isset($_SESSION['StudentUsername'])){ $studentUsername = $_SESSION['StudentUsername'];}
else $studentUsername = " ";

if (isset($_POST['date'])){ $firstDay = $_POST['date'];}
else if (isset($_POST['week'])){ $firstDay = $_POST['week'];}
else if (isset($_POST['selectedDay'])){$firstDay = $time->firstDayOfWeek($_POST['selectedDay']);}
else if (isset($_SESSION['date'])){$firstDay = $_SESSION['date'];}
else $firstDay = $time->firstDayOfWeek(date("m/d/y"));


$timeCard = new TimeCard($studentUsername,$firstDay);


?>

<h3>View Hours</h3>

<form action='view_student_timecard.php' method="post">
    <table border="1" align="center">
	<tr> <th>Student</th></tr>
	<tr><td>
	<select name="Username">
	<?php foreach($students as $student){ 
		// create drop down of all students the current user is responsible for
		if($student->type == "Student"){
			if($student->username==$studentUsername){
				echo "<option selected='selected' value=" . $student->username .">" . $student->lName .", ". $student->fName . ' - ' .$student->username . "</option>";
			}
			else {echo "<option value=" . $student->username .">"  . $student->lName .", ". $student->fName . ' - ' .$student->username . "</option>";} 
		}
	}
	?>
	</select></td></tr>
	</table>
<center><input type="submit" value = "View Student"/></center>
</form>
<br>

	<table id="<?php 
				 $status = current(explode(' ', $timeCard->status));
	       		 switch($status) {
	       		    case "Open":
			    	 echo "table-view";
				 break;
			    case "Submitted":
			    	 echo "table-submitted"; 
			    	 break;
			    case "Approved":
			    	 echo "table-approved";
				 break;
			    case "Rejected":
			    	 echo "table-rejected";
			    	 break;
			    default:
				echo "table-submitted";
			}
	       	  ?>" align="center">
		<tr>
			<th colspan='5'><center><?php echo  'Week of '. $firstDay;?></center></th>
		</tr>
		<tr> 
			<td colspan='5' ><center><b>Status: <?php echo $timeCard->status;?> </b></center></td>
		</tr>
		<tr>
			<th><center>Date</center></th>
			<th><center>Task</center></th>
			<th><center>Time in</center></th>
			<th><center>Time out</center></th>
			<th><center>Total</center></th>
			
		</tr>
	
		<!--Script for producing the entire weeks timecard-->
		<?php
		
		//each index is the total hours for that day of the week where 0 = Monday
		$dayTotalHours = array();
		
		//index to keep track of the day in the array
		$dayIndex = 0;
		
		foreach ($timeCard->days as $day){
			
			echo "<tr><td  style=";
			switch($status) {
	       		    case "Open":
			    	 echo "'background: #ededfc'";
				 break;
			    case "Submitted":
			    	 echo "'background:#ebebeb'"; 
			    	 break;
			    case "Approved":
			    	 echo "'background:#caffb5'";
				 break;
			    case "Rejected":
			    	 echo "'background:#ffd6d6'";
			    	 break;
			    default:
				 echo "'background:#ebebeb'"; 
			}
			echo (($day->size != 0)? "rowspan='$day->size '>" :">") . 
				$day->dayOfWeek. ", ". $day->date . "</td>";
	
			
			if ($day->size == 0){
				echo "<td></td>\n";
				echo "<td></td>\n";
				echo "<td></td>\n";
				echo "<td></td>\n";
				echo "</tr>";
			}
			else{
				

				
				foreach($day->hours as $hours){
					
					//store the totals for each day
					$entryTotalHours = $time->timeBetween($hours->start, $hours->end);
					array_push($dayTotalHours,$entryTotalHours);

					echo "<td><center>". $hours->task."</center></td>\n";					
					echo "<td><center>".$hours->start."</center></td>\n";
					echo "<td><center>".$hours->end."</center></td>\n";
					echo "<td><center>". number_format($time->hoursToDecimal($entryTotalHours),2) ."</center></td>\n";
					
					echo "</tr>";
					
					
				}
				
			
			}
		}
		
		
		//calculate the total hours for the week
		$weekTotalHours = $time->totalHours($dayTotalHours);
		
		?>
		<tr>
			<!-- <td><center>Status:</center></td> -->
			<td colspan='4' align="right" border-right="1px solid white"><b>Total Hours </b></td>
			<td ><center><b><?php echo number_format($time->hoursToDecimal($weekTotalHours),2) ?></b></center> </td>
		</tr>
		
	
	</table>

	<table id="table-clear">
	<?php 
		echo '<td width="50%" align="right">';
		echo '<form action="Scripts/approveCard.php" method="post">';
		echo "<input type='hidden' name='timeCard' value='". base64_encode(serialize($timeCard)) ."'>";
		if ($timeCard->status == "Submitted"){
			echo '<input type="submit" value="Approve" /></center>';
		} else {echo '<input type="submit" disabled="true" value="Approve" /></center>';}
		echo '</form>';
		echo '</td>';		

		echo '<form action="Scripts/rejectCard.php" method="post">';
		echo "<input type='hidden' name='timeCard' value='". base64_encode(serialize($timeCard)) ."'>";
		echo '<td width="50%" align="left">';
		if ($timeCard->status == "Submitted"){
		   	echo '<input type="submit" value="Reject" />';
			echo '<input type="text" value="Comment" name="comment" />';
			
		} else {
		        echo '<input type="submit" disabled="true" value="Reject" />';
			echo '<input type="text" disabled="true" value="Comment" name="comment" />';
		}
		echo '</td>';
		echo '</form>';		
	?>
	</table>

<br><br><hr>
<table id="table-clear">
<td align="left">
		<form action="view_student_timecard.php" method="post" >
				<input type="hidden" name="date" value=<?php echo $time->offsetDay($firstDay, -7)?> />
				<input type="hidden" name="Username" value="<?php echo $studentUsername?>" />
				<input type="submit" value="Previous"/> 
		</form>	
</td>
<td align="right">
		<form action="view_student_timecard.php" method="post" >
			 	<font size=2>Day: </font>
			 	<input type="hidden" name="Username" value="<?php echo $studentUsername?>" />
	        	<input name="selectedDay" type="text" value=<?php echo $firstDay;?>>
	        	<input type="submit" value="Go"/> 
	    </form>
</td>
<td align="left">
		<form action="view_student_timecard.php" method="post" >
		 	<font size=2>Week:</font>
			<select name="week">
	        	<?php
					$weeks = $time->weeksOfYear();
					$len= count($weeks);
					for($i=0;$i<$len;$i++){
						if ($weeks[$i]==$firstDay){
							echo '<option selected="selected" value="' . $weeks[$i] .'">'.$weeks[$i].'</option>';
						}
						else {echo '<option value="' . $weeks[$i] .'">'.$weeks[$i].'</option>';}
					}
				?>
	        </select>
	        <input type="hidden" name="Username" value="<?php echo $studentUsername?>" />
	        <input type="submit" value="Go"/> 
	   </form>
</td>
<td align="right">
		<form action="view_student_timecard.php" method="post" >
				<input type="hidden" name="date" value=<?php echo $time->offsetDay($firstDay, 7)?> />
				<input type="hidden" name="Username" value="<?php echo $studentUsername?>" />
				<input type="submit" value="Next"/> 
		</form>
</td>
</table>

	<?php $page->include_footer(); ?>
