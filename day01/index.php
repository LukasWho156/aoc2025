<!DOCTYPE html>
<html>
    <head>
        <title>Day 01</title>
    </head>
    <body>
        <?php

// Day 01. Not the most elegant solution, but I'm tired and wanna go to bed.

$filename = "./" . (isset($_GET["testdata"]) ? "test_input.dat" : "input.dat");

//echo($filename . "<br>");

$data = file_get_contents($filename);
$data = preg_split('/$\R?^/m', $data);

$cur_val = 50;
$zero_count = 0;
$exact_zero_count = 0;

foreach($data as $row) {
    $dir = ($row[0] == 'L') ? -1 : 1;
    $val = intval(substr($row, 1));
    $zero_count += floor($val / 100);
    $val = $val % 100;
    if($dir < 0 && $val >= $cur_val && $cur_val > 0) {
        $zero_count += 1;
    }
    if($dir > 0 && $val + $cur_val >= 100) {
        $zero_count += 1;
    }
    $cur_val += $dir * $val;
    if($cur_val < 0) {
        $cur_val += 100;
    }
    if($cur_val >= 100) {
        $cur_val -= 100;
    }
    if($cur_val == 0) {
        $exact_zero_count += 1;
    }
    echo($row . ", " . $cur_val . ", " . $exact_zero_count . ", " . $zero_count . "<br>");
}

echo($exact_zero_count . "<br>" . $zero_count);

        ?>
    </body>
</html>