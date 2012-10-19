<?php
include_once('Classes/User.php');
include_once('Classes/Student.php');
include_once('Classes/Supervisor.php');
include_once('Classes/Bookkeeper.php');
include_once('Classes/Administrator.php');
session_start();
$user = unserialize($_SESSION['User']);
if (!(get_class($user) == "Supervisor" || get_class($user) == "Administrator")){echo '<META HTTP-EQUIV="refresh" content="0; url=logout.php">'; die(); }

include('Classes/Page.php'); 
$page = new Page("View Users");

isset($_GET['order']) ? $order=$_GET['order'] : $order = "ascending";
isset($_GET['sort']) ? $sort=$_GET['sort'] : $sort = "lName";

// Returns the opposite of ascending/descending given one
function changeOrder($order){
    if ($order=="ascending"){
        $newOrder="descending";
    }
    else {
    	$newOrder="ascending";
    }
    return $newOrder;
}
?>

<h3>View Users</h3>

<table id="table-view">
	<tr>
		<th width="25%">
		    <a href=<?php 
		            // Dynamically changes the link so that you can view ascending or descending
		       	    if ($sort=="type") $orderLink=changeOrder($order); 
			    else $orderLink="ascending"; 
			    echo "'view_users.php?sort=type&order=".$orderLink."'"; ?>>Type</a> </th>
		<th width="25%">
		    <a href=<?php 
		       	    if ($sort=="username") $orderLink=changeOrder($order); 
			    else $orderLink="ascending"; 
			    echo "'view_users.php?sort=username&order=".$orderLink."'"; ?>>User</a> </th>
		<th width="25%">
		    <a href=<?php 
		       	    if ($sort=="fName") $orderLink=changeOrder($order); 
			    else $orderLink="ascending"; 
			    echo "'view_users.php?sort=fName&order=".$orderLink."'"; ?>>First Name</a> </th>
		<th width="25%">
		    <a href=<?php 
		       	    if ($sort=="lName") $orderLink=changeOrder($order); 
			    else $orderLink="ascending"; 
			    echo "'view_users.php?sort=lName&order=".$orderLink."'"; ?>>Last Name</a> </th>
	</tr>
	
	<!--table displaying users-->
	<?php 
	// if there is a message to display (something about a user being
	// added, removed, or edited) display it, and clear it
	if(isset($_SESSION['message'])){
		echo $_SESSION['message'];
	}
	unset($_SESSION['message']);
	// display each user that the user has permission to view
	if (isset($_GET['sort'])){
	    $sort=$_GET['sort'];
	    switch($_GET['sort']){
		case "type":
		     $users = $user->getPermissions("type"); break;
		case "username":
		     $users = $user->getPermissions("username"); break;
		case "lName":
		     $users = $user->getPermissions("lName"); break;
		case "fName":
		     $users = $user->getPermissions("fName"); break;
	    }
	}
	else $users = $user->getPermissions();
	if ($order=="descending") { $users=array_reverse($users);}
	foreach($users as $lowerUser){ 
	
		echo "<tr>";
		echo "<td>".$lowerUser->type."</td>";
		echo "<td>".$lowerUser->username."</td>";
		echo "<td>".$lowerUser->fName."</td>";
		echo "<td>".$lowerUser->lName."</td>";
		echo "</tr>";
		
		}	
		
	?>
	
</table>

<?php $page->include_footer(); ?>

