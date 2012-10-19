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
if (!(get_class($user) == "Student")){echo '<META HTTP-EQUIV="refresh" content="0; url=logout.php">'; die(); }

$page = new Page("Time Card");

$time = new TimeHelper();

// retrieve date information
if (isset($_POST['date'])){ $firstDay = $_POST['date'];}
else if (isset($_POST['week'])){ $firstDay = $_POST['week'];}
else if (isset($_POST['selectedDay'])){$firstDay = $time->firstDayOfWeek($_POST['selectedDay']);}
else if (isset($_SESSION['date'])){$firstDay = $_SESSION['date'];}
else $firstDay = $time->firstDayOfWeek(date("m/d/y"));

$timeCard = new TimeCard($user->username,$firstDay);


echo '<h3>Student Time Card</h3>';

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
			<th colspan='7'><center><?php echo  'Week of '. $firstDay;?></center></th>
		</tr>
		<tr> 
			<td colspan='7' ><center><b>Status: <?php echo $timeCard->status;?> </b></center></td>
		</tr>
		<tr>
			<th><center>Date</center></th>
			<th><center>Task</center></th>
			<th><center>Time in</center></th>
			<th><center>Time out</center></th>
			<th><center>Total</center></th>
			<th><center>Edit</center></th>
			<th><center>Delete</center></th>
			
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
					
					$s=serialize($hours);
					if($timeCard->status == 'Approved' || $timeCard->status == 'Submitted'){
						echo "<td align=center><input type='submit' disabled='true' value='Edit'/></td> ";
						echo "<td align=center><input type='submit' disabled='true' value='Delete'/></td> ";
					}
					else {
						echo "
						<td align=center>
						<form action='edit_timecard.php' method='post' >
							<input type='hidden' name='hours' value='".base64_encode($s)."'>
			        		<input type='submit' value='Edit'/> 
			        	</form>
			   			</td>\n";
					
		   			echo "
						<td align=center>
						<form action='Scripts/deleteHours.php' method='post' >
							<input type='hidden' name='hours' value='".base64_encode($s)."'>
			        		<input type='submit' value='Delete'/> 
			        	</form>
			   			</td>\n";
					}
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
			<td colspan='3' align='left'><b><?php echo number_format($time->hoursToDecimal($weekTotalHours),2) ?></b></td>
		</tr>
		
	
	</table>
	<!-- <td><center>Send to form for submitting timecards</center></td> -->
<form action="Scripts/submitCard.php" method="post">
	<input type='hidden' name='timeCard' value='<?php echo base64_encode(serialize($timeCard)); ?>'>
	<?php 
		if($timeCard->status == 'Approved' || $timeCard->status == 'Submitted'){
			echo '<center><input type="submit" disabled="true" value= "Submit"/></center>';
		} else {echo '<center><input type="submit" value= "Submit"/></center>';}
	?>
</form>

<br><br><hr>

<table id="table-clear">
<td align="left">
		<form action="view_timecard.php" method="post" >
				<input type="hidden" name="date" value=<?php echo $time->offsetDay($firstDay, -7)?> />
				<input type="submit" value="Previous"/> 
		</form>	
</td>
<td align="right">
		<form action="view_timecard.php" method="post" >
			 	<font size=2>Day: </font>
	        	<input name="selectedDay" type="text" value=<?php echo $firstDay;?>>
	        	<input type="submit" value="Go"/> 
	    </form>
</td>
<td align="left">
		<form action="view_timecard.php" method="post" >
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
	        <input type="submit" value="Go"/> 
	   </form>
</td>

<td align="right">
		<form action="view_timecard.php" method="post" >
				<input type="hidden" name="date" value=<?php echo $time->offsetDay($firstDay, 7)?> />
				<input type="submit" value="Next"/> 
		</form>
</td>
</table>

	<?php $page->include_footer(); ?>
