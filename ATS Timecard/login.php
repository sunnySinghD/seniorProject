<?php 

include ('Classes/Page.php');
$page = new Page("Login");
?>
<h3>Log in</h3>

<!--Form for submitting log in information
		send the username and password from the
		user input form to the verification script-->
<form action='Scripts/verify.php' method='POST'>
    Username:<br><input type='text' name='Username'><br>
    Password:<br><input type='password' name='Password'><br>
    <input type='submit' value='Log in'>
</form>

<?php $page->include_footer() ?>