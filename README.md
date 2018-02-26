# DateTime Programming Assignment
Tested using PHP 5.6.31.
## Author
Quang Do

## Description
This project consists of three PHP files:
* index.php 
* date_functions.php, which contains the deliverables
* unit_tests.php

unit_tests.php relies on the PHPUnit framework (specifically a PHP Archive of version 5, "phpunit-5.phar") available [here](https://phar.phpunit.de/phpunit-5.phar). This PHAR file should be located in the same directory as the PHP files. The three PHP files should be placed in the root directory of your web server (e.g. www/ in the case of Apache).

## index.php
index.php is simply a GUI for access to the date functions. It is mainly there for simple debugging purposes as it does not currently support time (e.g. hours, minutes and seconds). Please 'include' the date_functions.php file in your own index.php file for direct access to the functions.

## Functions
The following describes the usage of the three requested functions (which are located in date_functions.php). Please 'include' this file in your own PHP file in order to run these methods.

### Function 1: Number of Days
```php
num_days(DateTime $startDate, DateTime $endDate [, int $outputFormat [, DateTimeZone $timezone1 [, DateTimeZone $timezone2]]])
```
Returns the number of days (**full 24 hour days**) between two dates.
* num_days accepts a starting date and an ending date at a minimum. These values must be of the type DateTime. Actual order of the dates does not matter.
  * The DateTime objects can have their timezones set before being passed to this function. This means that the 4th and 5th parameters would not be required. Including the 4th and/or 5th parameters will take preference over the timezone information stored in the DateTime objects.
* The third parameter (and first optional parameter) of $outputFormat must be between -1 and 3 (inclusive).
  * -1 indicates that the return value will be the default--the number of days.
  * 0 indicates that a conversion of seconds is performed and returned. Values of 1, 2 and 3 refer to conversions of minutes, hours and years, respectively. The number of years will be provided to two decimal places. Be aware that these conversions are performed **after** the calculation of number of days. As a result, a value of 0 will be returned in the case of 0 days.
* The last two parameters refer to the timezones for the starting date and ending date, in that order. These values should be DateTimeZone objects containing the required (PHP-supported) timezone.
  *  For example, a DateTimeZone object for Adelaide's timezone would be defined by:
        ```php
        $adelaideZone = new DateTimeZone('Australia/Adelaide');
        ```
  * This variable ($adelaideZone) would then be passed as either $timezone1 or $timezone2 in the function.
  * Naturally, a timezone may be set for only one DateTime if required.
* **Errors**:
  *  A return value of -1 indicates that invalid dates were provided and DateTime objects must be used for these parameters.
  *  A return value of -2 indicates an invalid output format was specified. This value must be between -1 and 3 (inclusive).
  *  A return value of -3 indicates an invalid DateTimeZone has been used.
  
### Function 2: Number of Week Days
```php
num_week_days(DateTime $startDate, DateTime $endDate [, int $outputFormat [, DateTimeZone $timezone1 [, DateTimeZone $timezone2]]])
```
Refer to Function 1. As opposed to days, the function returns the number of *week* days.

### Function 3: Number of Weeks
```php
num_weeks(DateTime $startDate, DateTime $endDate [, int $outputFormat [, DateTimeZone $timezone1 [, DateTimeZone $timezone2]]])
```
Refer to Function 1. As opposed to days, the function returns the number of *weeks*.

### Additional Information on Timezones
If a DateTime object is passed with no timezone set, it will be treated as UTC-0. If only one of the DateTime objects has a timezone set, we aware that the other DateTime object will be UTC-0.

## Unit Tests
As previously explained, the unit tests require "phpunit-5.phar" to be located in the same directory as the project PHP files. The test can be run (if *php* itself is part of the classpath) via the following command:
```bash
php phpunit-5.phar unit_tests.php
```
The unit tests do not require an active web server.

## Example Code
* Requesting the number of days between two dates with preset timezones:
    ```php
    $startDate = new DateTime('19-02-2018 12:01:00 am', new DateTimeZone('Australia/Adelaide'));
    $endDate = new DateTime('26-02-2018 12:01:00 am', new DateTimeZone('Australia/Adelaide')); 
    $numDays = num_days($startDate, $endDate);
    echo $numDays; //Prints 7
    ```
* Requesting the number of days between two dates by passing different timezones:
    ```php
    $startDate = new DateTime('19-02-2018 12:01:00 am');
    $startTimezone = new DateTimeZone('Australia/Adelaide');
    $endDate = new DateTime('26-02-2018 12:01:00 am');
    $endTimezone = new DateTimeZone('Australia/Sydney');
    $numDays = num_days($startDate, $endDate, -1, $startTimezone, $endTimezone);
    echo $numDays; //Prints 6
    ```
* Requesting the number of week days between two dates with preset timezones and the output in minutes:
    ```php
    $startDate = new DateTime('19-02-2018 12:01:00 am', new DateTimeZone('Australia/Adelaide'));
    $endDate = new DateTime('26-02-2018 12:01:00 am', new DateTimeZone('Australia/Adelaide')); 
    $numWeekDayMins = num_week_days($startDate, $endDate, 1);
    echo $numWeekDayMins; //Prints 6 Days * 24 Hours * 60 Minutes = 8640 Minutes
    ```
* Requesting the number of weeks between two dates with a UTC timezone for the second date and the output in hours:
    ```php
    $startDate = new DateTime('19-02-2018 12:01:00 am');
    $endDate = new DateTime('26-12-2018 12:01:00 am'); 
    $numWeekHours = num_week_days($startDate, $endDate, 2, new DateTimeZone('Australia/Adelaide'));
    echo $numWeekHours; //Prints 44 Weeks * 7 Days * 24 Hours = 7392 Hours
    ```