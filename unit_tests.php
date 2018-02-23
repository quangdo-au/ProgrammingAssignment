<!-- Author: Quang Do-->
<?php
include 'date_functions.php';

class UnitTest extends \PHPUnit_Framework_TestCase
{
    //TWO PARAMETER TESTS

    //num_days()
    //Calculating days between two  dates
    public function test_num_days_valid()
    {
        $startDate = new DateTime('01-01-2001 12:01:00 am');
        $endDate = new DateTime('02-02-2010 2:20:02 am');
        $this->assertEquals(3319, num_days($startDate, $endDate));
    }

    //Testing two dates that refer to the same time
    public function test_num_days_same()
    {
        $startDate = new DateTime('01-01-2001 12:01:00 am');
        $endDate = new DateTime('01-01-2001 12:01:00 am');
        $this->assertEquals(0, num_days($startDate, $endDate));
    }

    //Testing a start date that occurs after the end date
    public function test_num_days_reversed()
    {
        $endDate = new DateTime('08-07-2009 11:01:27 am');
        $startDate = new DateTime('21-04-2010 6:27:12 pm');
        $this->assertEquals(287, num_days($startDate, $endDate));
    }

    //Passing one non-DateTime object to the function
    public function test_num_days_string_1()
    {
        $endDate = "abc";
        $startDate = new DateTime('08-07-2009 11:01:27 am');
        $this->assertEquals(-1, num_days($startDate, $endDate));
    }

    //Passing two non-DateTime objects to the function
    public function test_num_days_string_2()
    {
        $endDate = "abc";
        $startDate = "def";
        $this->assertEquals(-1, num_days($startDate, $endDate));
    }


    //THREE PARAMETER TESTS
    
    //num_days()
    //Testing for seconds between a valid date
    public function test_num_days_valid_format(){
        $startDate = new DateTime('01-01-2001 12:01:00 am');
        $endDate = new DateTime('02-02-2010 2:20:02 am');
        $format = 0;
        $this->assertEquals(286761600, num_days($startDate, $endDate, $format));
    }

    //Testing for an invalid integer output format
    public function test_num_days_invalid_format_1(){
        $startDate = new DateTime('01-01-2001 12:01:00 am');
        $endDate = new DateTime('02-02-2010 2:20:02 am');
        $format = 5;
        $this->assertEquals(-2, num_days($startDate, $endDate, $format));
    }

    //Testing for an invalid non-integer output format
    public function test_num_days_invalid_format_2(){
        $startDate = new DateTime('01-01-2001 12:01:00 am');
        $endDate = new DateTime('02-02-2010 2:20:02 am');
        $format = array('abc');
        $this->assertEquals(-2, num_days($startDate, $endDate, $format));
    }



}

?>