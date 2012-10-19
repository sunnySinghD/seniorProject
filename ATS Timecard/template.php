<?php 
include('Classes/Page.php'); 
$page = new Page("Template");
?>

<h3>Template Header</h3>

<p>
Main content goes here ...
</p>

<?php $page->include_footer() ?>