<?php 


include('variables/Page.php'); 
$page = new Page("About");
?>

<h3>About</h3>

<p>
Main content goes here ...
</p>

<?php $page->include_footer() ?>