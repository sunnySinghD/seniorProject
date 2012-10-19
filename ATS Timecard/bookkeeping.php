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
if (!(get_class($user) == "Bookkeeper" || get_class($user) == "Administrator")){echo '<META HTTP-EQUIV="refresh" content="0; url=logout.php">'; die(); }


$page = new Page("View Hours");

$students= $user->getPermissions();

$time = new TimeHelper();

// retrieve informatin from previous user interaction
$studentUsername = isset($_POST['Username'])? $_POST['Username']: " ";
$firstDay = isset($_POST['date'])? $_POST['date']: $time->offsetDay($time->firstDayOfWeek(date("m/d/y")), -7);
$firstDay = isset($_POST['week'])? $_POST['week']: $firstDay;
$timeCard = new TimeCard($studentUsername,$firstDay);

$secondDay = isset($_POST['date'])? $_POST['date']: $time->firstDayOfWeek(date("m/d/y"));
$secondDay = isset($_POST['weekTwo'])? $_POST['weekTwo']: $secondDay;
$timeCardTwo = new TimeCard($studentUsername,$secondDay);

?>

<h3>View Hours</h3>

<?php
if ($firstDay==$secondDay) {
   echo "Warning: You have selected to display time cards for the same week";
}
?>

<!--form for supervisors and admins to view student hours-->
<form action='bookkeeping.php' method="post">
    <table>
	<tr> 
	    <th>Student</th>
	    <th>Week One</th>
	    <th>Week Two</th>
	</tr>
	<tr>
	    <td>
		<select name="Username">
	    	<?php 
			// go through students and produce drop down containing all students viewable by the
			//   current user
		foreach($students as $student){ 
			if($student->type == "Student"){
				if($student->username==$studentUsername){
					echo "<option selected='selected' value=" . $student->username .">" . $student->lName .", ". $student->fName . ' - ' .$student->username . "</option>";}
				else {
					echo "<option value=" . $student->username .">"  . $student->lName .", ". $student->fName . ' - ' .$student->username . "</option>";} 
			}
		}
		?>
		</select>
	    </td>
	    <!--Select box for first week timecard-->
	    <td>
		<select name="week">
	    	<?php
		    $weeks = $time->weeksOfYear();
		    $len= count($weeks);
		    for($i=0;$i<$len;$i++){
		        if ($weeks[$i]==$firstDay){
			   echo '<option selected="selected" value="' . $weeks[$i] .'">'.$weeks[$i].'</option>';}
			else {echo '<option value="' . $weeks[$i] .'">'.$weeks[$i].'</option>';}
		    }
		?>
	        </select>
	    </td>
	    <!--Select box for second week timecard-->
	    <td>
		<select name="weekTwo">
	    	<?php
		    $weeks2 = $time->weeksOfYear();
		    $len= count($weeks2);
		    for($i=0;$i<$len;$i++){
		        if ($weeks2[$i]==$secondDay){
			   echo '<option selected="selected" value="' . $weeks2[$i] .'">'.$weeks2[$i].'</option>';}
			else {echo '<option value="' . $weeks2[$i] .'">'.$weeks2[$i].'</option>';}
		    }
		?>
	        </select>
	    </td>
	</tr>
    </table>
    <center><input type="submit" value = "View Student" onclick="<?php if($studentUsername != " ") { $history = new History($user->username, "Viewed Student <i>$studentUsername</i> time cards for the weeks $firstDay and $secondDay.");
	$user->writeHistory($history);} ?>"/></center>
</form>

<br>

<form action="" method="post">
    <!--Create the first weeks table-->
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
				
				$dayTotal = 0;
				$hoursDataWritten = false;
	    		foreach($day->hours as $hours){
	    			
	    			//store the totals for each day
					$entryTotalHours = $time->timeBetween($hours->start, $hours->end);
					array_push($dayTotalHours,$entryTotalHours);
	    			
	        		echo "<td>".$hours->start."</td>\n";
					echo "<td>".$hours->end."</td>\n";
					echo "<td>". $hours->task."</td>\n";
		
					//$decHours = number_format($time->hoursToDecimal($time->timeBetween($hours->start, $hours->end)), 2);
					//$dayTotal += $decHours;
			
					if($hoursDataWritten == false){
						echo "<td align='center' rowspan='".$day->size."'>". $time->getHoursInDay($day)."</td>\n";
						$hoursDataWritten = true;
					}
					echo "</tr>";
					//array_push($weekOneHours, $time->timeBetween($hours->start, $hours->end));
	    		}
			}
		}
		
		
		//calculate the total hours for the week
		$weekTwoTotalHours = $time->totalHours($dayTotalHours);
		
		?>
		<tr>
			<!-- <td><center>Status:</center></td> -->
			<td colspan='4' align="right" border-right="1px solid white"><b>Total Hours </b></td>
			<td ><center><b><?php echo number_format($time->hoursToDecimal($weekTwoTotalHours),2) ?></b></center> </td>
		</tr>
		
	
	</table>

	<table id="table-clear">
	</table>
    <br>

    <!--Create the second weeks table-->
    <table id="<?php 
				 $status = current(explode(' ', $timeCardTwo->status));
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
			<th colspan='5'><center><?php echo  'Week of '. $secondDay;?></center></th>
		</tr>
		<tr> 
			<td colspan='5' ><center><b>Status: <?php echo $timeCardTwo->status;?> </b></center></td>
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
		
		foreach ($timeCardTwo->days as $day){
			
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
				

				$dayTotal = 0;
				$hoursDataWritten = false;
				foreach($day->hours as $hours){
					
					//store the totals for each day
					$entryTotalHours = $time->timeBetween($hours->start, $hours->end);
					array_push($dayTotalHours,$entryTotalHours);

					echo "<td><center>". $hours->task."</center></td>\n";					
					echo "<td><center>".$hours->start."</center></td>\n";
					echo "<td><center>".$hours->end."</center></td>\n";
					
					if($hoursDataWritten == false){
						echo "<td align='center' rowspan='".$day->size."'>". $time->getHoursInDay($day)."</td>\n";
						$hoursDataWritten = true;
					}
					
					echo "</tr>";
					
					
				}
				
			
			}
		}
		
		
		//calculate the total hours for the week
		$weekOneTotalHours = $time->totalHours($dayTotalHours);
		
		?>
		<tr>
			<!-- <td><center>Status:</center></td> -->
			<td colspan='4' align="right" border-right="1px solid white"><b>Total Hours </b></td>
			<td ><center><b><?php echo number_format($time->hoursToDecimal($weekOneTotalHours),2) ?></b></center> </td>
		</tr>
		
	
	</table>

	<table id="table-clear">
	</table>
    
</form>
<br>

<!--Display total hours for both weeks-->
<table id="table-clear">
    <td>
    <font size="3">Total Hours for Both Weeks:
    <?php 
    if ($studentUsername != " ") {
       $total=array($weekOneTotalHours, $weekTwoTotalHours); 
       $total=$time->totalHours($total);
       $decTotal = number_format($time->hoursToDecimal($total), 2);
       echo $decTotal . " Hours";
    }
    ?>
    </font>
    </td>
</table>

<?php $page->include_footer(); ?>