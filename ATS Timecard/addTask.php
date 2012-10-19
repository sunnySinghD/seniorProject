<?php
header( 'Location: newTask.php' );
$db = mysql_connect("localhost","root", "");
if (!$db){
	die('Could not connect: ' . mysql_error());
}

mysql_select_db("DB475", $db);

$sql="INSERT INTO tasks (Task)
VALUES
('$_POST[task]')";

if (!mysql_query($sql,$db)){
	die('Error: ' . mysql_error());
}

mysql_close($db)

?>