<!-- Author: Quang Do-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Date </title>
</head>

<body>
<?php include 'date_functions.php'; ?>

<?php
$selectedID = -1;
$loadForm = 0;
if (isset($_POST['function_form'])) {
    //Determine the selected function from the dropdown list
    $selectedID = $_POST['function_form'][0];
    //Modify the form to have the appropriate fields
}
?>

<h1>DateTime Programming Assignment</h1>
<form name="calculate_form[]" method="POST">
    <fieldset>
        <legend>
            <h2>
                <form name="function_form" method="POST">
                    <select name="function_form[]" onchange="this.form.submit()">
                        <!-- Ensuring the right option is selected. -->
                        <option value="0" name="function_form[num_days]" <?php if (($selectedID <= 0)) {
                            echo 'selected';
                        }; ?>>Number of Days
                        </option>
                        <option value="1" name="function_form[num_weekdays]" <?php if (($selectedID == 1)) {
                            echo 'selected';
                        }; ?>>Number of Week Days
                        </option>
                        <option value="2" name="function_form[num_weeks]" <?php if (($selectedID == 2)) {
                            echo 'selected';
                        }; ?>>Number of Weeks
                        </option>
                    </select name="function_form[]">
                </form>
            </h2>
        </legend>
        <?php
        $description = '';
        //Load the num_days form
        if ($selectedID <= 0) {
            $description = '<em>days</em>';
        } else if ($selectedID == 1) { //Load the num_weekdays form
            $description = '<em>week days</em>';
        } else if ($selectedID == 2) { //Load the num_weeks form
            $description = '<em>weeks</em>';
        }
        ?>
        This form calculates the number of <?php echo $description; ?> between the starting date and the ending date.
        <p><label>Start Date: <input type="date" name="calculate_form[start_date]"/></label></p>
        <p><label>End Date: <input type="date" name="calculate_form[end_date]"/></label></p>
        <p><input type="submit" value="Calculate"/></p>
    </fieldset>
</form>

<?php
if (isset($_POST['calculate_form'])) {
    $values = $_POST['calculate_form'];
    //print_r($values);
    //Ensure the date inputs are not empty
    if (!empty($values['start_date']) && !empty($values['end_date'])) {
        //echo "Has values!";
        //Retrieve form values
        $startDate = $values['start_date'];
        $endDate = $values['end_date'];

        try {
            $startDate = new DateTime($startDate);
            $endDate = new DateTime($endDate);
        } catch (Exception $e) {
            echo "Invalid date values provided. <br>";
            return; //End execution
        }

        $output = "Between " . $startDate->format('l, d-M-Y H:i:s') . " and " . $endDate->format('l, d-M-Y H:i:s') . ": ";
        if ($selectedID == 0) {
            $numDays = numDays($startDate, $endDate);
            $dayText = ($numDays == 1) ? ' day.': ' days.'; //Ensuring plural/singular form is correctly used
            echo $output . $numDays . $dayText;
        } else if ($selectedID == 1) {
            $numWeekDays = numWeekDays($startDate, $endDate);
            $weekDayText = ($numWeekDays == 1) ? ' week day.': ' week days.';
            echo $output . $numWeekDays . $weekDayText;
        } else if ($selectedID == 2) {
            $numWeeks = numWeeks($startDate, $endDate);
            $weekText = ($numWeeks == 1) ? ' week.': ' weeks.';
            echo $output . $numWeeks . $weekText;
        }
    }
}
?>


</body>
</html>