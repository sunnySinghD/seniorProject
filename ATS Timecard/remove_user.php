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
$page = new Page("Remove User");


?>

<h3>Remove User</h3>

<!--Form for removing user-->
<form action='Scripts/removing.php' method="post">
    <table align="center">

	<tr>
	    <th> User: </th>
	</tr>
	
	<!--Drop down for username-->
	<tr>
	    <td>
	    <select name="Username">
			<?php 
			foreach($user->permissions as $val){
				$userObj = $user->UserDBHelper->getUser($val)
    		?>  
   		 	<option value='<?php echo $userObj->username?>'>  
        		<?php   
  					echo $userObj->fName . " " . $userObj->lName . " (" . $userObj->username . ")";
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