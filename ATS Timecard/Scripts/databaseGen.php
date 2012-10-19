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
$sql = "CREATE TABLE cards
(
User text,
Date text,
HoursIn text,
HoursOut text,
Task text,
Approved int,
Submitted int
)";

// Execute query
mysql_query($sql,$db);

$sql = "CREATE TABLE users
(
Username varchar(255) NOT NULL,
Type text,
PRIMARY KEY (Username)
)";

// Execute query
mysql_query($sql,$db);

$sql = "INSERT INTO users (Username, Type) VALUES('admin', 'Administrator' ) ";

// Execute query
if (mysql_query($sql,$db)){
	echo "User 'admin' added of type 'Administrator' <br>";
}
else{
	echo "Error adding user 'admin': " . mysql_error();
}

$sql = "INSERT INTO users (Username, Type) VALUES('stud', 'Student' ) ";

// Execute query
if (mysql_query($sql,$db)){
	echo "User 'stud' added of type 'Student' <br>";
}
else{
	echo "Error adding user 'stud': " . mysql_error();
}

$sql = "INSERT INTO users (Username, Type) VALUES('book', 'Bookkeeper' ) ";

// Execute query
if (mysql_query($sql,$db)){
	echo "User 'book' added of type 'Bookkeeper' <br>";
}
else{
	echo "Error adding user 'book': " . mysql_error();
}

$sql = "INSERT INTO users (Username, Type) VALUES('super', 'Supervisor' ) ";

// Execute query
if (mysql_query($sql,$db)){
	echo "User 'super' added of type 'Supervisor' <br>";
}
else{
	echo "Error adding user 'super': " . mysql_error();
}

mysql_close($db);
?>
