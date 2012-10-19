<?php 
include_once('variables/User.php');
include_once('variables/Student.php');
include_once('variables/Supervisor.php');
include_once('variables/Bookkeeper.php');
include_once('variables/Administrator.php');


session_start();
// retrieve user object
$user = unserialize($_SESSION['User']);
// if the user is not a supervisor or administrator, do not allow
//   access to the page
if (!(get_class($user) == "Supervisor" || get_class($user) == "Administrator")){echo '<META HTTP-EQUIV="refresh" content="0; url=logout.php">'; die(); }

include('variables/Page.php');
$page = new Page("Edit User");

include_once('variables/DBHelper.php');
// connect to the database
$dbHelper = new DBHelper("DB475", "");
$dbHelper->connect();

?>

<h3>Edit User</h3>

<!--Form for editing users-->
<!--passes information to backend script editing.php-->
<form action='editing.php' method="post">
    <table border="1" align="center">

	<tr>
	    <th> Username </th>
	    <th> SetToType </th>
	</tr>
	
	<!--Table for logging hours-->
	<tr>
		<!--drop down menu for selecting user to edit-->
	    <td>
	    <select name="Username">
			<?php 
				$result = $dbHelper->getAllUsers();
		     
    			while($row = mysql_fetch_array($result)) {  
    		?>  
   		 	<option value="<?php echo $row['Username']; ?>">  
        		<?php   
  					echo $row['Username'];   
  				?>  
  			</option>  
    		<?php }?> 
	    </select>
	    </td>
		<!--drop down menu for setting new type of user-->
	    <td>
	    <select name="SetToType">
	        <option value="Student" ><?php echo "Student" ?> </option>
		<option value="Supervisor" ><?php echo "Supervisor" ?> </option>
		<option value="Bookkeeper" ><?php echo "Bookkeeper" ?>
</option>
		<option value="Administrator" ><?php echo "Administrator" ?> </option>
	    </select>
	    </td>

	</tr>
    </table>
    
	<center><input type="submit"/></center>
</form>

<?php $page->include_footer(); ?>