<?php

class TimeHelper
{
    public $today = "";

    const timezone = 'EST';

    function __construct() {
    	date_default_timezone_set(self::timezone);
        $today = date("m-d-y");
    }

    // Returns a string of the day given an int 0-6
    public function int_to_day($num) {
    	if ($num > 6 | $num < 0) {
	    die('int_to_day($num), 0<$num<6');
	}
        switch ($num) {
	    case 0:
	        return "Mon";
	    case 1:
	    	return "Tue";
	    case 2:
	    	return "Wed";
	    case 3:
	    	return "Thu";
	    case 4:
	    	return "Fri";
	    case 5:
	    	return "Sat";
	    case 6:
	    	return "Sun";
	}
    }

    // Returns first day of the week
    // Can also give an input to increment to a specific day in the week
    public function first_day_of_week($add=0) {
    	$todaysDay = date("N");
        $diff = 0;
        while ($todaysDay != 1) {
            $todaysDay = $todaysDay - 1;
            $diff = $diff + 1;
        }

        $firstDayOfWeek = date("d")-$diff;
	$date = date("m-d-y", mktime(0,0,0,date("m"),$firstDayOfWeek+$add,date("y")));

    	return $date;
    }

}

?>