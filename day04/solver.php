<?php

include './shared/util.php';

function solve(string $data) {

    $data = read_map($data);
    $debug_log = [];

    $debug_log[] = $data["width"].", ".$data["height"];

    $removals = [];
    
    while(true) {
        $good_rolls = 0;
        $buffer = $data;
        for($x = 0; $x < $data["width"]; $x++) {
            for($y = 0; $y < $data["height"]; $y++) {
                if(map_get_val_at($data, $x, $y) != '@') {
                    continue;
                }
                $neighbours = 0;
                for($dx = -1; $dx <= 1; $dx++) {
                    for($dy = -1; $dy <= 1; $dy++) {
                        if($dx == 0 && $dy == 0) {
                            continue;
                        }
                        if(map_get_val_at($data, $x + $dx, $y + $dy) == '@') {
                            $neighbours++;
                        }
                    }
                }
                if($neighbours < 4) {
                    map_set_val_at($buffer, $x, $y, '.');
                    $good_rolls++;
                }
            }
        }
        if($good_rolls > 0) {
            $removals[] = $good_rolls;
            $data = $buffer;
        } else {
            break;
        }
    }

    return [
        "Part1" => $removals[0],
        "Part2" => array_sum($removals),
        "Debug" => $debug_log,
    ];

    // almost foiled by an empty trailing line. gotta be more careful with input in the future.

}

?>