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

## Functions
The following describes the usage of the three requested functions (which are located in date_functions.php). Please "include" this file in your own PHP file in order to run these methods.

### Function 1: Number of Days
```php
num_days(DateTime $startDate, DateTime $endDate [, int $outputFormat [, DateTimeZone $timezone1 [, DateTimeZone timezone2]]])
```
* num_days accepts a starting date and an ending date at a minimum. These values must be of the type DateTime. Actual order of the dates does not matter.
* The third parameter (and first optional parameter) of $outputFormat must be between -1 and 3 (inclusive).
  * -1 indicates that the return value will be the default--the number of days.
  * 0 indicates that a conversion of seconds is performed and returned. Values of 1,2 and 3 refer to conversions of minutes, hours and years, respectively.
* The last two parameters refer to the timezones for the starting date and ending date, in that order. These values should be DateTimeZone objects containing the required (PHP-supported) timezone.
  *  For example, a DateTimeZone object for Adelaide's timezone would be defined by:
        ```php
        $adelaideZone = new DateTimeZone('Australia/Adelaide');
        ```
  * This variable ($adelaideZone) would then be passed as either $timezone1 or $timezone2 in the function.
* **Errors**:
  *  A return value of -1 indicates that invalid dates were provided and DateTime objects must be used for these parameters.
  *  A return value of -2 indicates an invalid output format was specified. This value must be between -1 and 3 (inclusive).
  
### Function 2: Number of Week Days
```php
num_week_days(DateTime $startDate, DateTime $endDate [, int $outputFormat [, DateTimeZone $timezone1 [, DateTimeZone timezone2]]])
```
Refer to Function 1. As opposed to days, the function returns the number of *week* days.

### Function 3: Number of Weeks
```php
num_weeks(DateTime $startDate, DateTime $endDate [, int $outputFormat [, DateTimeZone $timezone1 [, DateTimeZone timezone2]]])
```
Refer to Function 1. As opposed to days, the function returns the number of *weeks*.

## Unit Tests
As previously explained, the unit tests require "phpunit-5.phar" to be located in the same directory as the project PHP files. The test can be run (if *php* itself is part of the classpath) via the following command:
```bash
php phpunit-5.phar unit_tests.php
```
The unit tests do not require an active web server.
