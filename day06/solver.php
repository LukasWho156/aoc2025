<?php

// part 1 feels easy enough

// ... which of course means part 2 is gonna be annoying. oh well.

function solve($data) {

    $debug_log = [];

    $data = preg_split('/$\R?^/m', $data);

    // some extra parsing for part 2: mirror the input.
    $flipped_data = [];
    for($y = 0; $y < strlen($data[0]); $y++) {
        $flipped_data[$y] = '';
        for($x = 0; $x < sizeof($data); $x++) {
            $flipped_data[$y] .= $data[$x][$y];
        }
    }
    $flipped_data[] = '   '; // stupid hack, but helps to finish off the last problem.

    $data = array_map(fn ($line) => preg_split('/ +/', $line), $data);
    $data = array_map(fn ($row) => array_values(array_filter($row, fn ($word) => $word != '')), $data);

    $results = [];
    for($prob = 0; $prob < sizeof($data[0]); $prob++) {
        $numbers = [];
        for($line = 0; $line < sizeof($data) - 1; $line++) {
            $numbers[] = intval($data[$line][$prob]);
        }
        $operator = $data[sizeof($data) - 1][$prob];
        switch($operator) {
            case '+':
                $debug_log[] = array_sum($numbers);
                $results[] = array_sum($numbers);
                break;
            case '*':
                $debug_log[] = array_product($numbers);
                $results[] = array_product($numbers);
                break;
        }
    }

    $debug_log[] = "---------";
    $debug_log[] = "PART II";
    $debug_log[] = "---------";

    $results_2 = [];
    $numbers = [];
    $operator = '';
    foreach($flipped_data as $row) {
        $debug_log[] = $row;
        if(preg_match('/^ +$/', $row) == 1) {
            $debug_log[] = "--------";
            switch($operator) {
                case '+':
                    $debug_log[] = array_sum($numbers);
                    $results_2[] = array_sum($numbers);
                    break;
                case '*':
                    $debug_log[] = array_product($numbers);
                    $results_2[] = array_product($numbers);
                    break;
            }
            $debug_log[] = "--------";
            $numbers = [];
            $operator = '';
            continue;
        }
        if(str_contains($row, '+')) {
            $operator = '+';
        }
        if(str_contains($row, '*')) {
            $operator = '*';
        }
        $numbers[] = intval($row);
    }

    return [
        "Part1" => array_sum($results),
        "Part2" => array_sum($results_2),
        "Debug" => $debug_log,
    ];
}