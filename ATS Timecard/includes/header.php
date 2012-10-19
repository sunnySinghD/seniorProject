<!--Header-->
<!--Add pictures and other cool looking stuff-->

<div id="header">

    <h2></h2>
<?php

	include_once('Classes/User.php');
	@session_start();
	if(isset($_SESSION['User'])){
		$user = unserialize($_SESSION['User']);
		echo "<p align='right' style='color:white'>";
		echo "<a href='logout.php' style='color:white'>Logout ";
	    	echo "[<b> ", $user->username, " </b> - ", $user->type, " ]</a></p>";
	}
?>
</div> <!-- end #header -->
