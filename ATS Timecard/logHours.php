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
$page = new Page("Log Hours");

include_once('variables/DBHelper.php');
$dbHelper = new DBHelper("DB475", "");
$dbHelper->connect();
?>

<h3>Log Hours</h3>

<!--Determines the first day of the week-->
<?php
include('variables/TimeHelper.php');
$time = new TimeHelper(); 
echo "Week of ", $time->first_day_of_week();
?>

<!--Form for submitting hours-->
<form action="submitCard.php" method="post">
    <table border="1" align="center">

	<tr>
	    <th> Date: </th>
	    <th> Time in: </th>
            <th> Time out: </th>
	    <th> Task: </th>	
	</tr>
	
	<!--Table for logging hours-->
	<tr>
	    <td>
	    <select name="date">
	        <option value=<?php echo $time->first_day_of_week(); ?> ><?php echo "Mon, ", $time->first_day_of_week(); ?> </option>
		<option value=<?php echo $time->first_day_of_week(1); ?> ><?php echo "Tue, ", $time->first_day_of_week(1); ?> </option>
		<option value=<?php echo $time->first_day_of_week(2); ?> ><?php echo "Wed, ", $time->first_day_of_week(2); ?> </option>
		<option value=<?php echo $time->first_day_of_week(3); ?> ><?php echo "Thu, ", $time->first_day_of_week(3); ?> </option>
		<option value=<?php echo $time->first_day_of_week(4); ?> ><?php echo "Fri, ", $time->first_day_of_week(4); ?> </option>
		<option value=<?php echo $time->first_day_of_week(5); ?> ><?php echo "Sat, ", $time->first_day_of_week(5); ?> </option>
		<option value=<?php echo $time->first_day_of_week(6); ?> ><?php echo "Sun, ", $time->first_day_of_week(6); ?> </option>
	    </select>
	    </td>
	    <td>
		<input type="text" name="hoursin" />
	    </td>
	    <td>
		<input type="text" name="hoursout" />
	    </td>
	    <td>
		<select name="task">
			<?php 
				$sql = "SELECT * FROM `tasks`";
		    	$result=mysql_Query($sql);
		     
    			while($row = mysql_fetch_array($result)) {  
    		?>  
   		 	<option value="<?php echo $row['Task']; ?>">  
        		<?php   
  					echo $row['Task'];   
  				?>  
  			</option>  
    		<?php }?> 

	    </select>
	    </td>
	</tr>
    </table>
    
	<center><input type="submit"/></center>
</form>

<?php $page->include_footer(); ?>