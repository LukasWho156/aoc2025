<?php

// surprisingly simple part 2 today. I'll take it!
// overall fun little problem, enjoyed it much more than yesterday's.

function solve(string $data) {

    $debug_log = [];
    $data = preg_split('/$\R?^/m', $data);
    $data = array_filter($data, fn ($row) => preg_match('/^\.*$/', $row) != 1);
    $data = array_values($data);

    $beams = [];

    $start = strpos($data[0], 'S');
    $beams[$start] = 1;

    $no_splits = 0;

    for($i = 1; $i < sizeof($data); $i++) {
        $debug_log[] = $data[$i];
        $debug_log[] = var_export($beams, true);
        $cur_keys = array_keys($beams);
        foreach($cur_keys as $key) {
            if($data[$i][$key] == '^') {
                $no_splits++;
                $beams[$key - 1] += $beams[$key];
                $beams[$key + 1] += $beams[$key];
                unset($beams[$key]);
            }
        }
    }

    return [
        "Part1" => $no_splits,
        "Part2" => array_sum($beams),
        "Debug" => $debug_log,
    ];

}

?>