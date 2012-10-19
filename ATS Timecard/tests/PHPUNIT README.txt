
I realize my directories may not be the same, but this is how I was able to run phpunit


As seen from here: http://katsande.com/running-phpunit-tests-from-eclipse-helio

Using xampp on windows


In Eclipse:
	Run > External Tools > External Tools Configurations...

In configuration Dialogue:
--Add a new configuration
--Name = PHPUnit
--Location =  c:/xampp/php/php.exe (location of PHP executable in xampp)
--Workspace = ${workspace_loc:/ATS Timecard/tests} (Choose browse from workplace)

-- By Arguments, Click variables>edit variables>new variable
-- add the location of TestSuite.php  (ie "C:\xampp\htdocs\ATS Timecard\tests\testSuite.php")
-- name it test_loc

--For Arguments type [location of phpunit] ${test_loc} 
	"C:\xampp\php\phpunit" ${test_loc}




TO RUN:

***First, Make sure all tests are uncommented in testSuite.php

Run > External Tools > PHPUnit

