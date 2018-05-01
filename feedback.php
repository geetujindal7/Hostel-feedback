<?php
    $cname = $_POST['customername'];
    $dob_date = $_POST['date'];
    $dob_month = $_POST['month'];
    $dob_year = $_POST['year'];
    $year = gmdate("Y");
    $month = gmdate("m");
    $day = gmdate("d");
    $age = $year - $dob_year; // $age calculates the user's age determined by only the year
    if ($month < $dob_month) { // this checks if the current month is before the user's month of birth
        $age = $age - 1;
    } else if (
            $month == $dob_month && $day >= $dob_date) { // this checks if the current month is the same as the user's month of birth and then checks if it is the user's birthday or if it is after it
        $age = $age;
    } else if ($month == $dob_month && $day < $dob_date) { //this checks if the current month is the user's month of birth and checks if it before the user's birthday
        $age = $age - 1;
    }

    //add all initial data into an matrix variable for easier access to them later
    //To access rowone use $rows[0][0], rowtwo $rows[1][0] ect.
    //The matrix is an array which contains multiple array. eg. 2-dimensional arrays
    //To get all the variables with $r1X simply retrieve the first array of the matrix eg $rows[0]
    $rows = array(array($_POST['rowone']), array($_POST['rowtwo']), array($_POST['rowthree']), array());

    //Similarities between row1 and row2 made me incoporate modulo value as an argument.
    function incmod($a, $m) {
        return ($a % $m) + 1;
    }

    //Population each row, with $populationCount number of elements, where each element is added with incmod(X, $mod)
    function populateRow($rowId, $populationCount, $mod) {
        //The global keyword is needed in order for the function to access the global variable.
        global $rows;
        $row = $rows[$rowId];
        while (sizeof($row) < $populationCount) {
            $rowInd = sizeof($row) - 1;
            $m = incmod($row[$rowInd], $mod);
            array_push($row, $m);
        }

        //Due to how php works with variables and references we need to set the row back into the global variable.
        $rows[$rowId] = $row;
    }

    //This function makes sure that the values allways are between 1 and 12.
    function bindToRange($v) {
        if ($v == 0)
            return 1;
        return ($v - 1) % 12 + 1;
    }

    //Population the first three rows
    populateRow(0, 7, 7);
    populateRow(1, 12, 12);
    populateRow(2, 12, 12);

    //Creating the forth row by nested forloops.
    //The first loop iterates over the entries in a row (in your example this would be the letters e.g r1a r1b ect)
    //The second (inner) loop iterates of the rows (in you example this would be the number you had in your variables.)
    //The sum over each of the three rows are added, then bound to 1-12 range, before being added to the forth row.
    for ($cId = 0; $cId < 7; $cId++) {
        $sum = 0;
        for ($rId = 0; $rId < 3; $rId++) {
            $sum += $rows[$rId][$cId];
        }
        array_push($rows[3], bindToRange($sum));
    }

    //Same as above, but for the last two remaining values. Should give a total of nine entries in the forth row.
    for ($cId = 7; $cId < 12; $cId++) {
        $sum = 0;
        for ($rId = 1; $rId < 3; $rId++) {
            $sum += $rows[$rId][$cId];
        }
        array_push($rows[3], bindToRange($sum));
    }

    function lower_than_2($var){
        return ($var > 1);
    }
    $cssClassName = "match";

    // array_count_values will count how many times each value is in the array
    $cssBase = array_count_values($rows[3]);
    // remove from array values that are lower than 2
    $cssBase = array_filter($cssBase, "lower_than_2");

    $cssNumber = array();
    $cssCounter = 1;
    // make $cssNumber be a mirror of $cssBase (same keys), but with serial values
    foreach ($cssBase as $key => $value) {
        $cssNumber[$key] = $cssCounter;
        $cssCounter++;
    }
    unset($cssCounter);
    // ------------------------------------------------

    ?>
    <!DOCTYPE HTML>
    <html>
        <head>
            <meta http-equiv="content-type" content="text/html" />
            <title>Result</title>
            <link rel="stylesheet" type="text/css" href="./css/style.css" />
        </head>

        <body>
            Customer Name: <?php echo $cname; ?><br />
            DOB: <?php echo $dob_date; ?> / <?php echo $dob_month; ?> / <?php echo $dob_year; ?><br />
            <b><?php echo $age; ?></b> Years Old
            <table>
                <?php
                //Instead of listing up (hard-coded) I've used nested forloops to generate the html.
                //The loops are similar to the ones above, but use sizeof keyword to figure out how many iterations it needs.

                $lines = sizeof($rows)+1; // $rows have 4 rows, we will need 1 more
                for ($rId = 0; $rId < $lines; $rId++) {
                    echo "<tr>\n";

                    if($rId < 3){
                        $row = $rows[$rId];
                        $rowSize = sizeof($row);

                        for ($cId = 0; $cId < $rowSize; $cId++) {
                            echo "<td>" . $row[$cId] . "</td>\n";
                        }
                    } else if($rId == 3){
                        $row = $rows[$rId];
                        $rowSize = sizeof($row);

                        for ($cId = 0; $cId < $rowSize; $cId++) {
                            echo "<td"; // open td
                            // if the value is in cssBase array, we will apply a css class
                            if(array_key_exists($row[$cId], $cssBase))
                                echo ' class="'. $cssClassName . $cssNumber[$row[$cId]] .'"';
                            echo ">"; // close td
                            echo $row[$cId];
                            echo "</td>\n";
                        }
                    } else if($rId == 4){
                        for ($cId = 0; $cId < 12; $cId++) {
                            if($cId == (($age-1)%12)){
                                echo '<td>'. "$age Years Old" .'</td>'."\n";
                            } else {
                                echo "<td></td>\n";
                            }
                        }
                    }
                    echo "</tr>\n";
                }

    // ------------------------------------------------

                ?>
            </table><br /><br />
            <a href="./" target="_blank" title="Calculate Again">Calculate Again</a>

        </body>
    </html>
