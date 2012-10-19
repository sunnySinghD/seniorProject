<?php 
include_once('Classes/User.php');
include_once('Classes/Student.php');
include_once('Classes/Supervisor.php');
include_once('Classes/Bookkeeper.php');
include_once('Classes/Administrator.php');
include_once('Classes/UserDBHelper.php');

@session_start();
$user = unserialize($_SESSION['User']);
if (!(get_class($user) == "Administrator")){echo '<META HTTP-EQUIV="refresh" content="0; url=logout.php">'; die(); }

// basic initialization
include('Classes/Page.php');
$page = new Page("Relations");
$UserDBHelper = new UserDBHelper();

// get the usernames of all supervsiors and bookkeepers
$types = array("Supervisor", "Bookkeeper");
$users = $UserDBHelper->getUsersOfTypes($types);

// retrieve user objects for all supervisors and bookkeepers
$userObjs = $UserDBHelper->getUsers($users);

// get the usernames of all students
$types2 = array("Student");
$students = $UserDBHelper->getUsersofTypes($types2);
// retrieve the user objects for all students
$studObjs = $UserDBHelper->getUsers($students);

?>

<h3>Relations</h3>

<!--Table for viewing and deleting all relations in system-->
<table border="1" align="center">
	<tr>
	    <th colspan=3>Relations</th>
	</tr>
	    <?php foreach($userObjs as $higherUser){
			foreach($higherUser->permissions as $student){
				$studObj = $UserDBHelper->getUser($student);
				//display the relations
				echo '<tr><td>'.$higherUser->lName .", ". $higherUser->fName . ' - ' .$higherUser->username .'</td>';
				echo '<td>'.$studObj->lName .", ". $studObj->fName . ' - ' .$studObj->username .'</td>';
				// display button for removing a single one
				echo "
					<td align=center>
						<form action='Scripts/removeRelation.php' method='post' >
							<input type='hidden' name='higherUser' value='".$higherUser->username."'>
							<input type='hidden' name='stud' value='".$studObj->username."'>
							<input type='submit' value='Remove'/> 
						</form>
					</td></tr>";
				}
	    }?>
    </table>

<!--Form for adding a relation-->
<form action="Scripts/addRelation.php" method="post">
    <table border="1" align="center">
	<tr>
	    <th>Select a User </th>
		<th>Select a Student for the User to Monitor</th>
	</tr>
		<?php
		// display supervisor/bookkeeper options in drop down
		echo '<tr><td> <select name="superORbook">';
				foreach($userObjs as $user){echo '<option value="'.$user->username.'">'.$user->lName .", ". $user->fName . ' - ' .$user->username .'</option>';}
		echo '</select></td>';
		// display student options in drop down
		echo '<td> <select name="Student">';
				foreach($studObjs as $stud){echo '<option value="'.$stud->username.'">'.$stud->lName .", ". $stud->fName . ' - ' .$stud->username .'</option>';}
		echo '</select></td>';
		?>
	</tr>
    </table>
    
	<center><input type="submit" value="Add Relation"/></center>
</form>

<?php $page->include_footer(); ?>