<!--Navigation Bar-->
<?php
include_once('Classes/User.php');
include_once('Classes/Student.php');
include_once('Classes/Supervisor.php');
include_once('Classes/Bookkeeper.php');
include_once('Classes/Administrator.php');
include_once('Classes/Browser.php');

@session_start();
if(isset($_SESSION['User'])){
	$user = unserialize($_SESSION['User']);
}
else {
	$user = NULL;
}

?>
<div id="nav" align="left">

    <?php
    // Adds a link to the navigation bar
    function addLink($pageName, $pageUrl, $description=""){
    	$browser = new Browser();
    	echo "<a ";
	// Checks if the link is the current page, highlights it if so
        if (strpos($_SERVER["PHP_SELF"], $pageUrl)) {
	    if ($browser->getBrowser()==Browser::BROWSER_FIREFOX) {
	       echo 'style="border:1px solid black; border-bottom:1px solid white; background:white; padding-top:3px;"';
	    }
	    else {
	       echo 'style="border:1px solid black; border-bottom:3px solid white; background:white; padding-top:3px;"';
	    }
	}
	echo "href='", $pageUrl, "'>", $pageName;
	if ($description != ""){
	    echo "<span><i>&rarr; ", $description, "</i></span>";
	}
	echo "</a>";
    }
    ?>    
    
    <?php 
	//Pages that admins can navigate to
	if(get_class($user) == "Administrator"){
		addLink("History", "view_history.php", "View everyones history");
	    addLink("Add User", "new_user.php", "Add a user to the database");
	    addLink("Remove User", "remove_user.php", "Remove a user from the database");
	    addLink("Edit User", "edit_user.php", "Edit user permissions");
	    addLink("View Users", "view_users.php", "View a list of all users in the database");
	    addLink("Tasks", "task.php", "Add a task for students to choose from");
	    addLink("View Time Cards", "view_student_timecard.php", "Approve and reject submitted student time cards");
	    addLink("Book Keeping", "bookkeeping.php", "View total hours for student time cards");
	    addLink("Manage Supervision", "manage_supervision.php", "View or change the users for which different supervisors and bookkeepers are responsible");
	}
	
	//Pages that supervisors can navigate to
	if(get_class($user) == "Supervisor"){
		addLink("View Time Cards", "view_student_timecard.php", "Approve and reject submitted student time cards");
	    addLink("Add User", "new_user.php", "Add a student to the database");
	    addLink("Remove User", "remove_user.php", "Remove a student from the database");
	    addLink("View Users", "view_users.php", "View a list of students that are under your supervision");
	    addLink("Tasks", "task.php", "Add a task for students to choose from");
	    addLink("History", "view_history.php", "View history of yourself and the students you supervise");
	}

	// Pages that book keepers can navigate to
	if(get_class($user) == "Bookkeeper"){
	    addLink("Book Keeping", "bookkeeping.php", "View total hours for student time cards");
	    addLink("History", "view_history.php", "View all of your history");
	}

	//Pages that students can navigate to
	if(get_class($user) == "Student"){
	    addLink("Log Hours", "log_hours.php", "Log your work hours for this week");
	    addLink("View Time Card", "view_timecard.php", "View your logged hours and edit entries if needed");   
	    addLink("History", "view_history.php", "View all of your history"); 
	}
    ?>

</div> 

