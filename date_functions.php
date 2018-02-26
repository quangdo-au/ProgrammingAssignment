<!-- Author: Quang Do-->
<?php
/* Return Error Codes:
 *  -1 = Invalid dates provided, DateTime objects must be used.
 *  -2 = Invalid output format specified, these values must be between -1 and 3 (inclusive).
 *  -3 = Invalid DateTimeZone specified.
 */


//Global Constants
const DAYS_TO_SECONDS = 86400; //Equal to 24 * 60 * 60
const DAYS_TO_MINUTES = 1440; //Equal to 24 * 60
const DAYS_TO_HOURS = 24;
const DAYS_TO_YEARS = 365; //Approximate--could use 365.25
const FORMATS = array(' Seconds', ' Minutes', ' Hours', ' Years');

//Challenge Q1+Q4,5
function num_days($startDate, $endDate, $outputFormat = -1, $startTimezone = null, $endTimezone = null)
{
    //Validate the function inputs
    $returnValue = validate($startDate, $endDate, $startTimezone, $endTimezone);
    if ($returnValue != 0) {
        return $returnValue;
    }

    //Calculate the difference between the two dates using PHP's diff method in order to reduce chance of errors.
    $difference = $endDate->diff($startDate);

    //Simply return the number of days if an output format is not specified.
    if ($outputFormat == -1) {
        return $difference->days;
    } else {
        //Otherwise return the duration in the chosen format.
        return day_convert($difference->days, $outputFormat);
    }
}

//Challenge Q2+Q4,5
function num_week_days($startDate, $endDate, $outputFormat = -1, $startTimezone = null, $endTimezone = null)
{
    $returnValue = validate($startDate, $endDate, $startTimezone, $endTimezone);
    if ($returnValue != 0) {
        return $returnValue;
    }

    $begin = $startDate;
    $end = $endDate;

    //Ensure $begin is the earlier date
    if ($startDate > $endDate) {
        $begin = $endDate;
        $end = $startDate;
    }


    $weekdayCount = 0;

    //If today is a week day and the ending date is not today, start at 1
    if ($begin->diff($end)->days > 0 && $begin->format('w') != 6 && $begin->format('w') != 0) {
        $weekdayCount++;
    }

    //Loop through the days until reaching the $end date
    //Increment each time a week day is encountered
    //If there are fewer than 24 hours difference between the two dates then end the while loop
    while ($begin->diff($end)->days > 0) {
        $begin->modify('+1 day');
        if ($begin->format('w') != 0 && $begin->format('w') != 6) {
            $weekdayCount++;
        }
    }

    if ($outputFormat == -1) {
        return $weekdayCount;
    } else {
        return day_convert($weekdayCount, $outputFormat);
    }
}

//Challenge Q3+Q4,5
function num_weeks($startDate, $endDate, $outputFormat = -1, $startTimezone = null, $endTimezone = null)
{
    $returnValue = validate($startDate, $endDate, $startTimezone, $endTimezone);
    if ($returnValue != 0) {
        return $returnValue;
    }

    $begin = $startDate;
    $end = $endDate;

    //Ensure $begin is the earlier date
    if ($startDate > $endDate) {
        $begin = $endDate;
        $end = $startDate;
    }

    //Loop through the days until reaching the $end date
    //Increment each time a day is encountered
    //Every mod 7, increment week by 1
    //Ensure there are more than 24 hours left before incrementing number of days
    $dayCount = 0;
    $weekCount = 0;
    while ($begin->diff($end)->days > 0) {
        $begin->modify('+1 day');
        $dayCount++;
        if ($dayCount % 7 == 0) {
            $weekCount++;
        }
    }

    if ($outputFormat == -1) {
        return $weekCount;
    } else {
        //Multiply by 7 to convert into days for the date_convert function.
        return day_convert($weekCount * 7, $outputFormat);
    }
}




//HELPER FUNCTIONS

//Validate the DateTime object
function date_validator($date)
{
    //Make sure the parameter is a DateTime object
    if ($date != null && $date instanceof DateTime) {
        return true;
    } else {
        return false;
    }

}

//Converts days into the specified output format.
function day_convert($duration, $outputFormat)
{
    if ($outputFormat >= 0 && $outputFormat < count(FORMATS)) {
        switch ($outputFormat) {
            case 0:
                return DAYS_TO_SECONDS * $duration;
                break;
            case 1:
                return DAYS_TO_MINUTES * $duration;
                break;
            case 2:
                return DAYS_TO_HOURS * $duration;
                break;
            case 3:
                return round(($duration / DAYS_TO_YEARS), 2);
                break;
            default:
                return -2;
                break;
        }
    } else {
        return -2;
    }
}

//Converts a DateTime object's timezone without affecting the time given
function configure_date($date, $timezone)
{
    if ($timezone == null) {
        return 0;
    } else if ($timezone instanceof DateTimeZone) {
        //Set the DateTime object's timezone and obtain the difference between it and UTC 0
        $offset = $timezone->getOffset($date);

        //Determine if new time has been added or subtracted from the DateTime object
        $sign = ($offset > 0) ? '+' : '-';
        $offset = abs($offset);

        //Calculate the difference in terms of hours and minutes
        $hours = gmdate('H', $offset);
        $minutes = gmdate('i', $offset);

        //Reset the date and time back to the user's original date and time
        //Double negative (e.g. UTC -x) would add time to return to the original time

        $date->modify("-$sign$minutes minute");
        $date->modify("-$sign$hours hour");

        $date->setTimezone($timezone);
        return 0;
    } else {
        //Not a DateTimeZone object
        return -3;
    }
}

function validate($startDate, $endDate, $startTimezone, $endTimezone)
{
    //Check if dates are valid
    if (!date_validator($startDate) || !date_validator($endDate)) {
        return -1;
    }

    //Ensure timezones are correctly set
    $startConf = configure_date($startDate, $startTimezone);
    $endConf = configure_date($endDate, $endTimezone);

    if ($startConf != 0) {
        return $startConf;
    }
    if ($endConf != 0) {
        return $endConf;
    }

    return 0;
}

?>