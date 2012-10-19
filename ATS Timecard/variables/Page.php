<?php

class Page
{
    public $name = "";

    // Page constructor
    function __construct($title) {
    	
    	$this->include_header();
    	
    	$this->name = $title;		
    	
    	$this->include_html_declarations($this->name);
        
		$this->include_nav();
    }

    // Includes html declarations
    public function include_html_declarations() {
    	echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
	     <html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>
	     <head>
	     <meta http-equiv='content-type' content='text/html; charset=utf-8' />
	     <meta name='description' content='' />
	     <meta name='keywords' content='' />  
	     <meta name='author' content='' />
	     <link rel='stylesheet' type='text/css' href='style.css' media='screen' />
	     <title>$this->name</title>
	     </head>";
    }

    // Includes the header
    public function include_header() {
    	
    	include('includes/header.php');
    	
    	echo "<body>
	     <div id='wrapper'>";
        
    }

    // Includes the navigation and start of the main content divider
    public function include_nav() {
    	include('includes/nav.php');
	echo "<div id='content'>";

    }

    // Main content goes here

    // Includes the end of the main content divider and footer
    public function include_footer() {
    	echo "</div> <!-- end #content -->";
    	include('includes/footer.php');
	echo "</div> <!-- End #wrapper -->
	     </body>
	     </html>";
    }

}

?>