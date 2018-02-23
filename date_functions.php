<!-- Author: Quang Do-->
<?php
//Global Constants
const DAYS_TO_SECONDS = 86400; //Equal to 24 * 60 * 60
const DAYS_TO_MINUTES = 1440; //Equal to 24 * 60
const DAYS_TO_HOURS = 24;
const DAYS_TO_YEARS = 365; //Approximate--could use 365.25
const FORMATS = array(' Seconds', ' Minutes', ' Hours', ' Years');

//Challenge Q1+Q4,5
function num_days($startDate, $endDate, $outputFormat = -1)
{
    //Check if dates are valid
    if (!date_validator($startDate) || !date_validator($startDate)) {
        return -1;
    }

    //Calculate the difference between the two dates using PHP's methods.
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
function num_week_days($startDate, $endDate, $outputFormat = -1)
{
    $begin = $startDate;
    $end = $endDate;

    //Ensure $begin is the earlier date
    if ($startDate > $endDate) {
        $begin = $endDate;
        $end = $startDate;
    }

    //Loop through the days until reaching the $end date
    //Increment each time a week day is encountered
    $weekdayCount = 0;
    while ($begin < $end) {
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
function num_weeks($startDate, $endDate, $outputFormat = -1)
{
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
    $dayCount = 0;
    $weekCount = 0;
    while ($begin < $end) {
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

//TODO: Validate the date
function date_validator($date)
{
    //Make sure the parameter is a DateTime object
    if ($date instanceof DateTime) {
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
                return $duration / DAYS_TO_YEARS;
                break;
            default:
                return -1;
                break;
        }
    } else {
        return -1;
    }
}

?>