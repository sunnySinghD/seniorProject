<?php
header( 'Location: viewCard.php' ) ;

$db = mysql_connect("localhost","root", "");
if (!$db){
	die('Could not connect: ' . mysql_error());
}

mysql_select_db("DB475", $db);

$sql="INSERT INTO cards (User, Date, HoursIn, HoursOut, Task, Approved, Submitted)
VALUES
('Max Power','$_POST[date]', '$_POST[hoursin]', '$_POST[hoursout]', '$_POST[task]', 0, 0)";

if (!mysql_query($sql,$db)){
	die('Error: ' . mysql_error());
}

mysql_close($db)

?>