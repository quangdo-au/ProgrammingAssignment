<!-- Author: Quang Do-->
<?php
include 'date_functions.php';

class UnitTest extends \PHPUnit_Framework_TestCase
{
    //[num_days] TWO PARAMETER TESTS (Two Dates)

    //Calculating days between two dates
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

    //Passing one null DateTime object
    public function test_num_days_null_1()
    {
        $endDate = null;
        $startDate = new DateTime('08-07-2009 11:01:27 am');
        $this->assertEquals(-1, num_days($startDate, $endDate));
    }

    //Passing two null DateTime objects
    public function test_num_days_null_2()
    {
        $endDate = null;
        $startDate = null;
        $this->assertEquals(-1, num_days($startDate, $endDate));
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

    //Testing for one preset timezone, same day DateTimes with different timezones (Default is UTC-0)
    //Should return 0 days as there are less than 24 hours between the two dates regardless of the
    //difference in day of the month
    public function test_num_days_tz_1()
    {
        $startDate = new DateTime('02-01-2013 11:59:00 pm', new DateTimeZone("Australia/Adelaide"));
        $endDate = new DateTime('01-01-2013 11:59:00 pm');
        $this->assertEquals(0, num_days($startDate, $endDate));
    }

    //Testing for two preset timezones
    //Should return 1 day due to the differences between timezones even though they are both on the same
    //day of the same month
    public function test_num_days_tz_2()
    {
        $startDate = new DateTime('01-01-2013 11:59:00 pm', new DateTimeZone("Pacific/Honolulu"));
        $endDate = new DateTime('01-01-2013 1:59:00 pm', new DateTimeZone("Australia/Adelaide"));
        $this->assertEquals(1, num_days($startDate, $endDate));
    }

    //Testing for daylight savings time: what appears to be more than 24 hours is, in fact, 23 hrs 58 minutes
    //due to the start time being non-existent (because the clocks were moved forward by an hour).
    public function test_num_days_dst()
    {
        $startDate = new DateTime('01-10-2017 2:01:00 am', new DateTimeZone("Australia/Adelaide"));
        $endDate = new DateTime('02-10-2017 2:59:00 am', new DateTimeZone("Australia/Adelaide"));
        $this->assertEquals(0, num_days($startDate, $endDate));
    }

    //Demonstrating that the DST test case is valid by only incrementing by one day
    public function test_num_days_dst_valid()
    {
        $startDate = new DateTime('02-10-2017 2:01:00 am', new DateTimeZone("Australia/Adelaide"));
        $endDate = new DateTime('03-10-2017 2:59:00 am', new DateTimeZone("Australia/Adelaide"));
        $this->assertEquals(1, num_days($startDate, $endDate));
    }




    //[num_days] THREE PARAMETER TESTS (Output Formats)

    //Testing for seconds between a valid date
    public function test_num_days_valid_seconds(){
        $startDate = new DateTime('01-01-2001 12:01:00 am');
        $endDate = new DateTime('02-02-2010 2:20:02 am');
        $format = 0;
        $this->assertEquals(286761600, num_days($startDate, $endDate, $format));
    }

    //Testing for minutes between a valid date
    public function test_num_days_valid_minutes(){
        $startDate = new DateTime('01-01-2001 12:01:00 am');
        $endDate = new DateTime('02-02-2010 2:20:02 am');
        $format = 1;
        $this->assertEquals(4779360, num_days($startDate, $endDate, $format));
    }

    //Testing for hours between a valid date
    public function test_num_days_valid_hours(){
        $startDate = new DateTime('01-01-2001 12:01:00 am');
        $endDate = new DateTime('02-02-2010 2:20:02 am');
        $format = 2;
        $this->assertEquals(79656, num_days($startDate, $endDate, $format));
    }

    //Testing for years between a valid date (two decimal places)
    public function test_num_days_valid_years(){
        $startDate = new DateTime('01-01-2001 12:01:00 am');
        $endDate = new DateTime('02-02-2010 2:20:02 am');
        $format = 3;
        $this->assertEquals(9.09, num_days($startDate, $endDate, $format));
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

    //Seconds dst test
    //Testing for seconds between a valid date
    //As the result is 0 days, the output should be 0 seconds
    public function test_num_days_seconds_dst(){
        $startDate = new DateTime('01-10-2017 2:01:00 am', new DateTimeZone("Australia/Adelaide"));
        $endDate = new DateTime('02-10-2017 2:59:00 am', new DateTimeZone("Australia/Adelaide"));
        $format = 0;
        $this->assertEquals(0, num_days($startDate, $endDate, $format));
    }

    //Demonstrating that a UTC based timezone would return a different result to seconds_dst
    public function test_num_days_seconds_dst_check(){
        $startDate = new DateTime('01-10-2017 2:01:00 am');
        $endDate = new DateTime('02-10-2017 2:59:00 am');
        $format = 0;
        $this->assertEquals(86400, num_days($startDate, $endDate, $format));
    }



    //[num_days] FOUR PARAMETER TESTS (Timezones 1)

    //Testing one valid timezone and one default timezone
    public function test_num_days_valid_tz_1(){
        $startDate = new DateTime('02-01-2013 11:59:00 pm');
        $endDate = new DateTime('01-01-2013 11:59:00 pm');
        $this->assertEquals(0, num_days($startDate, $endDate, -1, new DateTimeZone("Australia/Adelaide")));
    }

    //Testing an invalid DateTimeZone object
    public function test_num_days_invalid_tz_1(){
        $startDate = new DateTime('02-01-2013 11:59:00 pm');
        $endDate = new DateTime('01-01-2013 11:59:00 pm');
        $this->assertEquals(-3, num_days($startDate, $endDate, -1, "abc"));
    }





    //[num_days] FIVE PARAMETER TESTS (Timezones 2)

    //Testing two valid timezones over 1 day
    public function test_num_days_valid_tz_2(){
        $startDate = new DateTime('02-11-2018 6:40:40 pm');
        $endDate = new DateTime('03-11-2018 6:40:40 pm');
        $this->assertEquals(1, num_days($startDate, $endDate, -1, new DateTimeZone("Australia/Adelaide"), new DateTimeZone("Australia/Adelaide")));
    }

    //Testing two valid timezones over a span of days
    //No timezones would be 15 days but in fact is only 14 days
    public function test_num_days_valid_tz_3(){
        $startDate = new DateTime('02-11-2018 11:59:00 pm');
        $endDate = new DateTime('17-11-2018 11:59:00 pm');
        $this->assertEquals(14, num_days($startDate, $endDate, -1, new DateTimeZone("America/New_York"), new DateTimeZone("Australia/Adelaide")));
    }

    //Testing a single timezone with dst that moves forward at 2am
    public function test_num_days_valid_tz_dst_1(){
        $startDate = new DateTime('11-03-2018 2:01:00 am');
        $endDate = new DateTime('12-03-2018 2:59:00 am');
        $this->assertEquals(0, num_days($startDate, $endDate, -1, new DateTimeZone("America/New_York"), new DateTimeZone("America/New_York")));
    }

    //Verifying the solution of dst_1
    public function test_num_days_valid_tz_dst_1_check(){
        $startDate = new DateTime('11-03-2018 2:01:00 am', new DateTimeZone("America/New_York"));
        $endDate = new DateTime('12-03-2018 2:59:00 am', new DateTimeZone("America/New_York"));
        $this->assertEquals(0, num_days($startDate, $endDate, -1));
    }

    //Testing two timezones that have dst time moved forward at 2am
    public function test_num_days_valid_tz_dst_2(){
        $startDate = new DateTime('02-10-2017 2:01:00 am');
        $endDate = new DateTime('11-03-2018 2:59:00 am');
        $this->assertEquals(160, num_days($startDate, $endDate, -1, new DateTimeZone("Australia/Adelaide"), new DateTimeZone("America/New_York")));
    }




    //[num_week_days] TWO PARAMETER TESTS (Two Dates)

    //Testing two valid dates
    public function test_num_week_days_valid_1()
    {
        $startDate = new DateTime('19-2-2018 12:01:00 am');
        $endDate = new DateTime('23-2-2018 2:20:02 am');
        $this->assertEquals(5, num_week_days($startDate, $endDate));
    }

    //Testing two valid dates 2
    public function test_num_week_days_valid_2()
    {
        $startDate = new DateTime('01-01-2001 12:01:00 am');
        $endDate = new DateTime('02-02-2010 2:20:02 am');
        $this->assertEquals(2372, num_week_days($startDate, $endDate));
    }




    //[num_weeks] TWO PARAMETER TESTS (Two Dates)

    //Testing two valid dates
    public function test_num_weeks_valid_1()
    {
        $startDate = new DateTime('19-02-2018 12:01:00 am');
        $endDate = new DateTime('26-02-2018 2:20:02 am');
        $this->assertEquals(1, num_weeks($startDate, $endDate));
    }

    //Testing two valid dates: time1 is before time2
    public function test_num_weeks_valid_2()
    {
        $startDate = new DateTime('19-02-2018 2:00:00 pm');
        $endDate = new DateTime('26-02-2018 2:01:00 pm');
        $this->assertEquals(1, num_weeks($startDate, $endDate));
    }

    //Testing two valid dates: time 1 is after time2
    public function test_num_weeks_valid_3()
    {
        $startDate = new DateTime('19-02-2018 2:01:00 pm');
        $endDate = new DateTime('26-02-2018 2:00:00 pm');
        $this->assertEquals(0, num_weeks($startDate, $endDate));
    }

    //Testing two valid dates: many weeks
    //Based on dates, should be 486 weeks but in fact 485 weeks due to times.
    public function test_num_weeks_valid_4()
    {
        $startDate = new DateTime('01-12-2010 2:01:00 pm');
        $endDate = new DateTime('25-03-2020 2:00:00 pm');
        $this->assertEquals(485, num_weeks($startDate, $endDate));
    }
}

?>