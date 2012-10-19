<?php
//Assumes user "root" with pass "" and mysql running at localhost

$db = mysql_connect("localhost","root","");
if (!$db){
	die('Could not connect: ' . mysql_error());
}

mysql_select_db("AUTHDB", $db);

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

$sql = "INSERT INTO users (Username, Password) VALUES('stud2', 'stud2' ) ";

// Execute query
if (mysql_query($sql,$db)){
	echo "User 'stud2' added with password 'stud2' <br>";
}
else{
	echo "Error adding user 'stud2': " . mysql_error();
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

mysql_select_db("DB475", $db);


$sql = "INSERT INTO users (Username, FirstName, LastName,  Type) VALUES('admin','Addy', 'McAdmin', 'Administrator' ) ";

// Execute query
if (mysql_query($sql,$db)){
	echo "User 'admin' added of type 'Administrator' <br>";
}
else{
	echo "Error adding user 'admin': " . mysql_error();
}

$sql = "INSERT INTO users (Username, FirstName, LastName, Type) VALUES('stud', 'Mike', 'Lopez', 'Student' ) ";

// Execute query
if (mysql_query($sql,$db)){
	echo "User 'stud' added of type 'Student' <br>";
}
else{
	echo "Error adding user 'stud': " . mysql_error();
}

$sql = "INSERT INTO users (Username, FirstName, LastName,  Type) VALUES('stud2', 'John', 'Doe', 'Student' ) ";

// Execute query
if (mysql_query($sql,$db)){
	echo "User 'stud2' added of type 'Student' <br>";
}
else{
	echo "Error adding user 'stud2': " . mysql_error();
}

$sql = "INSERT INTO users (Username, FirstName, LastName,  Type) VALUES('book','Booky', 'McBook', 'Bookkeeper' ) ";

// Execute query
if (mysql_query($sql,$db)){
	echo "User 'book' added of type 'Bookkeeper' <br>";
}
else{
	echo "Error adding user 'book': " . mysql_error();
}

$sql = "INSERT INTO users (Username, FirstName, LastName,  Type) VALUES('super', 'Supey', 'McSuper', 'Supervisor' ) ";

// Execute query
if (mysql_query($sql,$db)){
	echo "User 'super' added of type 'Supervisor' <br>";
}
else{
	echo "Error adding user 'super': " . mysql_error();
}

$sql = "INSERT INTO userRelations (Username, RelateTo) VALUES('super','stud')";
if (!mysql_query($sql,$db)){echo "Error in query:".$sql.": ". mysql_error();}
$sql = "INSERT INTO userRelations (Username, RelateTo) VALUES('super','stud2')";
if (!mysql_query($sql,$db)){echo "Error in query:".$sql.": ". mysql_error();}
$sql = "INSERT INTO userRelations (Username, RelateTo) VALUES('book','stud')";
if (!mysql_query($sql,$db)){echo "Error in query:".$sql.": ". mysql_error();}
$sql = "INSERT INTO userRelations (Username, RelateTo) VALUES('book','stud2')";
if (!mysql_query($sql,$db)){echo "Error in query:".$sql.": ". mysql_error();}


$sql = "INSERT INTO tasks (Task) VALUES('Working' ) ";
if (!mysql_query($sql,$db)){echo "Error in query:".$sql.": ". mysql_error();}
$sql = "INSERT INTO tasks (Task) VALUES('Working hard' ) ";
if (!mysql_query($sql,$db)){echo "Error in query:".$sql.": ". mysql_error();}
$sql = "INSERT INTO tasks (Task) VALUES('Hardly working' ) ";
if (!mysql_query($sql,$db)){echo "Error in query:".$sql.": ". mysql_error();}

$sql="INSERT INTO hours (User, Date, Start, End, Task, Status) VALUES ('stud','11/30/11', '9:00AM', '2:00PM', 'Working','Open')";
if (!mysql_query($sql,$db)){echo "Error in query:".$sql.": ". mysql_error();}
$sql="INSERT INTO hours (User, Date, Start, End, Task, Status) VALUES ('stud2','12/03/11', '9:00AM', '2:00PM', 'Working hard','Open')";
if (!mysql_query($sql,$db)){echo "Error in query:".$sql.": ". mysql_error();}
$sql="INSERT INTO hours (User, Date, Start, End, Task, Status) VALUES ('stud','12/06/11', '9:00AM', '2:00PM', 'Working','Open')";
if (!mysql_query($sql,$db)){echo "Error in query:".$sql.": ". mysql_error();}
$sql="INSERT INTO hours (User, Date, Start, End, Task, Status) VALUES ('stud','12/06/11', '3:00PM', '5:00PM', 'Hardly working','Open')";
if (!mysql_query($sql,$db)){echo "Error in query:".$sql.": ". mysql_error();}
$sql="INSERT INTO hours (User, Date, Start, End, Task, Status) VALUES ('stud2','12/08/11', '9:00AM', '2:00PM', 'Working hard','Open')";
if (!mysql_query($sql,$db)){echo "Error in query:".$sql.": ". mysql_error();}


mysql_close($db);
?>