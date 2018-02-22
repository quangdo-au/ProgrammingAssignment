<?php
//Challenge Q1+Q4,5
function numDays($startDate, $endDate){
    $difference = $endDate->diff($startDate);
    return $difference->days;
}

//Challenge Q2+Q4,5
function numWeekDays($startDate, $endDate){
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
    while($begin != $end){
        $begin->modify('+1 day');
        if($begin->format('w') != 0 && $begin->format('w') != 6){
            $weekdayCount++;
        }
    }
    return $weekdayCount;
}

//Challenge Q3+Q4,5
function numWeeks($startDate, $endDate){
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
    while($begin != $end){
        $begin->modify('+1 day');
        $dayCount++;
        if($dayCount%7 == 0){
            $weekCount++;
        }
    }
    return $weekCount;
}

?>