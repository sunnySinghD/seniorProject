<?php
//Assumes user "root" with pass "" and mysql running at localhost

$db = mysql_connect("localhost","root","");
if (!$db){
	die('Could not connect: ' . mysql_error());
}
$sql = "DROP DATABASE DB475";
mysql_query($sql,$db);

// Create database
if (mysql_query("CREATE DATABASE DB475",$db)){
	echo "Database created <br>";
}
else{
	echo "Error creating database: " . mysql_error();
}

mysql_select_db("DB475", $db);
// Create task table
$sql = "CREATE TABLE tasks
(
Task text
)";

// Execute query
mysql_query($sql,$db);

// Create cards table
$sql = "CREATE TABLE hours
(
Id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
User text,
Date text,
Start text,
End text,
Task text,
Status text
)";

// Execute query
mysql_query($sql,$db);

$sql = "CREATE TABLE users
(
Username varchar(255) NOT NULL,
Type text,
FirstName text,
LastName text,
PRIMARY KEY (Username)
)";


// Execute query
mysql_query($sql,$db);

$sql = "CREATE TABLE userRelations
(
Id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
Username text,
RelateTo text
)";

mysql_query($sql,$db);


$sql = "CREATE TABLE history
(
Id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
User varchar(255) NOT NULL,
Description text,
Date text,
Time text
)";

// Execute query to add history table
mysql_query($sql,$db);

mysql_close($db);
?>
