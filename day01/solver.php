<?php

function solve(string $data) {

    $data = preg_split('/$\R?^/m', $data);

    $cur_val = 50;
    $zero_count = 0;
    $exact_zero_count = 0;

    $debug_log = [];

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
        $debug_log[] = ($row . ", " . $cur_val . ", " . $exact_zero_count . ", " . $zero_count);
    }

    $result = [
        "Part1" => $exact_zero_count,
        "Part2" => $zero_count,
        "Debug" => $debug_log,
    ];
    return $result;
    
}

?>