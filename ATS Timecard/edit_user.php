<?php 
include_once('Classes/User.php');
include_once('Classes/Student.php');
include_once('Classes/Supervisor.php');
include_once('Classes/Bookkeeper.php');
include_once('Classes/Administrator.php');

@session_start();
$user = unserialize($_SESSION['User']);
if (!(get_class($user) == "Supervisor" || get_class($user) == "Administrator")){echo '<META HTTP-EQUIV="refresh" content="0; url=logout.php">'; die(); }

include('Classes/Page.php');
$page = new Page("Edit User");

?>

<h3>Edit User</h3>

<!--Form for editing a user-->
<form action='Scripts/editing.php' method="post">
    <table border="1" align="center">

	<tr>
	    <th align="50%"> User </th>
	    <td>
	    <select name="User">
			<?php 
			// produce a drop down of editable users
			foreach($user->permissions as $val){
				$userObj = $user->UserDBHelper->getUser($val);
				echo "<option value=$userObj->username>$userObj->fName" . " " . $userObj->lName . " (" . $userObj->username . ")";  
				echo "</option>";
			} 
			?> 
	    </select></td>
	    </tr>
	    <tr>
		<th> First Name </th>
	    <td>
		<input type="text" name="fname" />
		</td>
		</tr>
		<tr>
		<th> Last Name </th>
		
		<td>
		<input type="text" name="lname" />
		</td>
		</tr>
		<tr>
	    <th> Set To Type </th>
	    <td>
	    <select name="Type">
		<?php
		// produce a drop down with the different types of user the user can make
		$count = count($user->editableUserTypes);
		for ($i = 0; $i < $count; $i++) {
			$val = $user->editableUserTypes[$i];
			echo "<option value=$val>$val </option>";
		}
		?>
	    </select>
	    </td>
	    </tr>
	
	
    </table>
    
	<center><input type="submit"/></center>
</form>

<?php $page->include_footer(); ?>