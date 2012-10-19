<!--Page for removing users-->

<?php 
include_once('variables/User.php');
include_once('variables/Student.php');
include_once('variables/Supervisor.php');
include_once('variables/Bookkeeper.php');
include_once('variables/Administrator.php');

session_start();
// retrieve user object
$user = unserialize($_SESSION['User']);
// if user is not a supervisor or administrator, deny access
if (!(get_class($user) == "Supervisor" || get_class($user) == "Administrator")){echo '<META HTTP-EQUIV="refresh" content="0; url=logout.php">'; die(); }

include('variables/Page.php');
$page = new Page("Remove User");

include_once('variables/DBHelper.php');

//connect to database
$dbHelper = new DBHelper("DB475", "");
$dbHelper->connect();

?>

<h3>Remove User</h3>

<!--Form for Removing users-->
<!--Send input to backend script removing.php-->
<form action='removing.php' method="post">
    <table border="1" align="center">

	<tr>
	    <th> Username: </th>
	</tr>
	<tr>
	    <td>
	    <select name="Username">
			<?php 
		    		$result= $dbHelper->getAllUsers();
		     
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
	</tr>
    </table>
    
	<center><input type="submit"/></center>
</form>

<?php $page->include_footer(); ?>