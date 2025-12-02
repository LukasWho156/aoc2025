<?php

// oh no, I should've seen part 2 coming. let's see if we can salvage anything from part 1.
// or maybe we just start over.

function get_first_half(string $number, bool $roundup = false) {
    $len = strlen($number);
    if($len % 2 == 1) {
        if($roundup) {
            return pow(10, floor($len / 2));
        } else {
            return pow(10, floor($len / 2)) - 1;
        }
    }
    return intval(substr($number, 0, $len / 2));
}

function double_val(int $number) {
    return pow(10, floor(log10($number) + 1)) * $number + $number; 
}

function solve(string $data) {

    $data = explode(",", $data);

    $invalids_1 = [];

    $debug_log = [];

    foreach($data as $area) {
        $bounds = explode("-", $area);
        $lower = intval($bounds[0]);
        $upper = intval($bounds[1]);
        $lower_half = get_first_half($bounds[0], true);
        $upper_half = get_first_half($bounds[1]);
        $debug_log[] = $area.", ".$lower_half.", ".$upper_half;
        if($lower_half > $upper_half) {
            continue;
        }
        for($i = $lower_half; $i <= $upper_half; $i++) {
            $doubled = double_val($i);
            if($doubled >= $lower && $doubled <= $upper) {
                $debug_log[] = $doubled." check!";
                $invalids_1[] = $doubled;
            }
        }
    }

    $sum_1 = array_sum($invalids_1);

    // part 2 starts here

    $debug_log[] = "---------";
    $debug_log[] = "PART II";
    $debug_log[] = "---------";

    $invalids_2 = [];

    foreach($data as $area) {
        $debug_log[] = $area;
        $bounds = explode("-", $area);
        $lower = intval($bounds[0]);
        $upper = intval($bounds[1]);
        for($i = $lower; $i <= $upper; $i++) {
            $i_as_str = strval($i);
            $len = strlen($i_as_str);
            for($seq_len = 1; $seq_len <= $len / 2; $seq_len++) {
                if($len % $seq_len != 0) {
                    continue;
                }
                $chunks = str_split($i_as_str, $seq_len);
                $comp = $chunks[0];
                foreach($chunks as $chunk) {
                    if($chunk != $comp) {
                        continue 2;
                    }
                }
                $debug_log[] = $i." check!";
                $invalids_2[] = $i;
                break;
            }
        }
    }

    $sum_2 = array_sum($invalids_2);

    $result = [
        "Part1" => $sum_1,
        "Part2" => $sum_2,
        "Debug" => $debug_log,
    ];
    return $result;
    
}

?>