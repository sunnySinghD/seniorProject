<?php 
include_once('Classes/User.php');
include_once('Classes/Student.php');
include_once('Classes/Supervisor.php');
include_once('Classes/Bookkeeper.php');
include_once('Classes/Administrator.php');

ini_set('display_errors',1); 
 error_reporting(E_ALL);

@session_start();
$user = unserialize($_SESSION['User']);
if (!(get_class($user) == "Supervisor" || get_class($user) == "Administrator")){echo '<META HTTP-EQUIV="refresh" content="0; url=logout.php">'; die(); }

include('Classes/Page.php');
$page = new Page("Add Users");


?>

<h3>Add Users</h3>


<!--Form for adding a user-->
<form action='Scripts/adding.php' method="post">
    <table>
		<tr>
	   		<th> Type: </th>
	     	<td>
	    		<select name="Type">
	       			<?php 
					// retrieve the different types of users that the current user can create
					foreach($user->editableUserTypes as $type){echo '<option value="'.$type.'">'.$type.'</option>';}?>
				</select>
	    	</td>
	    </tr>
	    <tr>
	    	<th> Username: </th>
	    	<td><input type="text" name="username" /></td>
	    </tr>
	    <tr>
			<th> First Name: </th>
			<td><input type="text" name="fname" /></td>
		</tr>
		<tr>
			<th> Last Name: </th>
			<td><input type="text" name="lname" /></td>
		</tr>
		<?php 
		// if the user is an administrator, they may choose a supervisor
		//   to set for the new user - this only applies if the new
		//   user will be a student
		if($user->type == "Administrator"){
			echo "<tr><th> Supervisor (Students only): </th>";
			$types = array();
			$types[] = "Supervisor";
			// create an array containing supervisor objects
			$supers = $user->UserDBHelper->getUsersOfTypes($types);
			$supervisors = array();
			foreach($supers as $sup){
				$supervisors[] = $user->UserDBHelper->getUser($sup);
			}
			// Create a drop down for supervisors
			echo '<td> <select name="Supervisor">';
				foreach($supervisors as $super){echo "<option value=$super->username>$super->fName $super->lName ($super->username)</option>";}
			echo '</select></td></tr>';
			
		}
		// otherwise, a supervisor is adding a user, and they automatically are added as
		//   a supervisor for the new student
		else { 	echo '<input type="hidden" value="'.$user->username.'" name="Supervisor">'; }
		?>
    </table>
	<center><input type="submit"/></center>
</form>

<?php $page->include_footer(); ?>