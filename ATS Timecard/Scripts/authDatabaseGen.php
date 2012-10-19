<?php
//Assumes user "root" with pass "" and mysql running at localhost

$db = mysql_connect("localhost","root","");
if (!$db){
	die('Could not connect: ' . mysql_error());
}
$sql = "DROP DATABASE AUTHDB";
mysql_query($sql,$db);

// Create database
if (mysql_query("CREATE DATABASE AUTHDB",$db)){
	echo "Database created <br>";
}
else{
	echo "Error creating database: " . mysql_error();
}

mysql_select_db("AUTHDB", $db);

// Create cards table
$sql = "CREATE TABLE users
(
Username text,
Password text
)";

// Execute query
if (mysql_query($sql,$db)){
	echo "Table 'users' created <br>";
}
else{
	echo "Error adding table: " . mysql_error();
}


$sql = "INSERT INTO users (Username, Password) VALUES('admin', 'admin' ) ";

// Execute query
if (mysql_query($sql,$db)){
	echo "User 'admin' added with password 'admin' <br>";
}
else{
	echo "Error adding user 'admin': " . mysql_error();
}

$sql = "INSERT INTO users (Username, Password) VALUES('stud', 'stud' ) ";

// Execute query
if (mysql_query($sql,$db)){
	echo "User 'stud' added with password 'stud' <br>";
}
else{
	echo "Error adding user 'stud': " . mysql_error();
}

$sql = "INSERT INTO users (Username, Password) VALUES('book', 'book' ) ";

// Execute query
if (mysql_query($sql,$db)){
	echo "User 'book' added with password 'book' <br>";
}
else{
	echo "Error adding user 'book': " . mysql_error();
}

$sql = "INSERT INTO users (Username, Password) VALUES('super', 'super' ) ";

// Execute query
if (mysql_query($sql,$db)){
	echo "User 'super' added with password 'super' <br>";
}
else{
	echo "Error adding user 'super': " . mysql_error();
}

mysql_close($db);
?>
