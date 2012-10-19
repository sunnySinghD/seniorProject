<?php 
include_once('variables/User.php');
include_once('variables/Student.php');
include_once('variables/Supervisor.php');
include_once('variables/Bookkeeper.php');
include_once('variables/Administrator.php');

session_start();
// retrieve the saved user object
$user = unserialize($_SESSION['User']);
// if the user is not of the appropriate type, do not allow them
//    access to the page
if (!(get_class($user) == "Supervisor" || get_class($user) == "Administrator")){echo '<META HTTP-EQUIV="refresh" content="0; url=logout.php">'; die(); }

include('variables/Page.php');
$page = new Page("Add Users");

include_once('variables/DBHelper.php');
// connect to database
$dbHelper = new DBHelper("DB475", "");
$dbHelper->connect();

?>

<h3>Add Users</h3>

<!--Form for adding a new user to the system-->
<!--User input send to backend php script adding.php-->
<form action='adding.php' method="post">
    <table border="1" align="center">

	<tr>
	    <th> Type: </th>
	    <th> Username: </th>
	</tr>
	<tr>
	    <td>
		<!--Drop down for user type selection-->
	    <select name="Type">
	        <option value="Student" ><?php echo "Student" ?> </option>
		<option value="Supervisor" ><?php echo "Supervisor" ?> </option>
		<option value="Bookkeeper" ><?php echo "Bookkeeper" ?> </option>
		<option value="Administrator" ><?php echo "Administrator" ?> </option>
	    </select>
	    </td>
		<!--Text box for entering username-->
	    <td>
		<input type="text" name="username" />
	    </td>
	</tr>
    </table>
    
	<center><input type="submit"/></center>
</form>

<?php $page->include_footer(); ?>