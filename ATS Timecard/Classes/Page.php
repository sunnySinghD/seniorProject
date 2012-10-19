<?php

class Page
{
    public $name = "";

    // Page constructor
    function __construct($title) {
    	
    	$this->name = $title;		
    	
    	$this->include_html_declarations($this->name);
        $this->include_header();
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
    	echo "<body>
	     <div id='container'>";
		echo "<div id='main'>";
        include('includes/header.php');
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
		echo "</div> <!-- end #main -->";
		echo "</div> <!-- End #container -->";
    	include('includes/footer.php');
		echo "
	     </body>
	     </html>";
    }

}

?>