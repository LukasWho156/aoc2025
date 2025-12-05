<?php

// okay. Feels like there's probably some smarter thing I could do here, like
// merging fresh areas and then ordering them by size, but I'm also tempted
// to just do the naive approach and see if it's fast enough.

function solve($data) {

    $debug_log = [];

    // parsing
    [$ranges, $ids] = preg_split('/$\R\R^/m', $data);
    $ranges = preg_split('/$\R?^/m', $ranges);
    $ranges = array_map(
        fn ($row) => array_map('intval', $row),
        array_map(fn ($row) => explode('-', $row), $ranges)
    );
    $ids = array_map('intval', preg_split('/$\R?^/m', $ids));

    $filtered = array_filter($ids,
        fn ($id) => array_find($ranges, fn ($range) => $range[0] <= $id && $range[1] >= $id) != null
    );

    // alright, part 2 actually does seem to require merging.

    // weird merging algorithm, let's hope it works.
    for($i = 0; $i < sizeof($ranges); $i++) {
        if($ranges[$i] == -1) {
            continue;
        }
        for($k = $i + 1; $k < sizeof($ranges); $k++) {
            if($ranges[$k][0] == -1) {
                continue;
            }
            [$lower_i, $upper_i] = $ranges[$i];
            [$lower_k, $upper_k] = $ranges[$k];
            $single_ranges = $upper_i + $upper_k - $lower_i - $lower_k + 2;
            $upper_any = max($upper_i, $upper_k);
            $lower_any = min($lower_i, $lower_k);
            $combined_range = $upper_any - $lower_any + 1;
            $overlap = $single_ranges - $combined_range;
            if($overlap > 0) {
                $debug_log[] = "merge {$lower_i}-{$upper_i} and {$lower_k}-{$upper_k} into {$lower_any}-{$upper_any}";
                $ranges[$k][0] = $lower_any;
                $ranges[$k][1] = $upper_any;
                $ranges[$i][0] = -1;
                $ranges[$i][1] = -1;
            }
        }
    }

    $all_valid_ids = array_sum(
        array_map(
            fn ($range) => $range[1] - $range[0] + 1,
            array_filter($ranges, fn ($range) => $range[0] != -1)
        )
    );

    return [
        "Part1" => sizeof($filtered),
        "Part2" => $all_valid_ids,
        "Debug" => $debug_log,
    ];
}