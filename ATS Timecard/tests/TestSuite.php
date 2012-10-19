<?php
require_once 'PHPUnit/Autoload.php';

require_once 'tests/TestDBHelper.php';
require_once 'tests/TestUser.php';
require_once 'tests/testStudent.php';
require_once 'tests/TestSupervisor.php';
require_once 'tests/TestBookkeeper.php';
require_once 'tests/TestAdministrator.php';
require_once 'tests/TestTimecard.php';
require_once 'tests/TestHours.php';
require_once 'tests/TestHistory.php';

class TestSuite extends PHPUnit_Framework_TestSuite{
 public static function suite()
    {
        $t = new TestSuite('TestUser');
        $t->addTestSuite('TestDBHelper');
        $t->addTestSuite('TestStudent');
        $t->addTestSuite('TestSupervisor');
        $t->addTestSuite('TestBookkeeper');
        $t->addTestSuite('TestAdministrator');
        $t->addTestSuite('TestTimecard');
		$t->addTestSuite('TestHours');
        return $t;
    }
}

?>