<?php

function solve(string $data) {

    $data = preg_split('/$\R?^/m', $data);
    $debug_log = [];

    $joltages = array_map(function ($row) {
        $symbols = str_split($row);
        $numbers = array_map(fn ($symbol) => intval($symbol), $symbols);
        $all_but_last = array_slice($numbers, 0, sizeof($numbers) - 1);
        $highest_first_digit = max($all_but_last);
        $highest_index = array_find_key($numbers, fn ($n) => $n == $highest_first_digit);
        $remaining = array_slice($numbers, $highest_index + 1);
        $highest_second_digit = max($remaining);
        $joltage = $highest_first_digit * 10 + $highest_second_digit;
        return $joltage;
    }, $data);

    // let's try to be a bit smarter for part 2

    $joltages_2 = array_map(function ($row) use (&$debug_log) {
        $symbols = str_split($row);
        $numbers = array_map(fn ($symbol) => intval($symbol), $symbols);
        $current_index = -1;
        $joltage = 0;
        for($i = 0; $i < 12; $i++) {
            $search_area = array_slice($numbers, $current_index + 1, sizeof($numbers) + $i - 12 - $current_index, true);
            $highest_digit = max($search_area);
            $joltage = 10 * $joltage + $highest_digit;
            $current_index = array_find_key($search_area, fn ($n) => $n == $highest_digit);
        }
        $debug_log[] = $joltage;
        return $joltage;
    }, $data);

    return [
        "Part1" => array_sum($joltages),
        "Part2" => array_sum($joltages_2),
        "Debug" => $debug_log,
    ];

    // almost foiled by an empty trailing line. gotta be more careful with input in the future.

}

?>