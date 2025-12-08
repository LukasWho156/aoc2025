<?php

// I may not know a lot of algorithms, but I do recognize Kruskal when I
// see it. Should be fun to implement.

// okay solution ended up ugly as hack but we've made it.

const REQ_CONS = 1000;

function solve(string $data) {

    $debug_log = [];
    $data = preg_split('/$\R?^/m', $data);

    $junctions = array_map(fn ($row) => array_map('intval', explode(',', $row)), $data);
    for($i = 0; $i < sizeof($junctions); $i++) {
        $junctions[$i]['circuit'] = $i;
    }

    $debug_log[] = var_export($junctions, true);

    $connections = [];
    for($i = 1; $i < sizeof($junctions); $i++) {
        for($k = 0; $k < $i; $k++) {
            $j1 = $junctions[$i];
            $j2 = $junctions[$k];
            $dist_sq = ($j1[0] - $j2[0]) * ($j1[0] - $j2[0])
                     + ($j1[1] - $j2[1]) * ($j1[1] - $j2[1])
                     + ($j1[2] - $j2[2]) * ($j1[2] - $j2[2]);
            $connections[] = [
                'j1' => $i,
                'j2' => $k,
                'dist' => $dist_sq,
            ];
        }
    }

    usort($connections, fn ($a, $b) => $b['dist'] - $a['dist']);

    $no_connections = 0;
    $failures = 0;
    $final_connection = 0;
    $junctions_2 = $junctions; // stupid thing for part 1
    while(sizeof($connections) > 0) {
        $no_connections++;
        $con = array_pop($connections);
        $debug_log[] = var_export($con, true);
        if($junctions[$con['j1']]['circuit'] == $junctions[$con['j2']]['circuit']) {
            $debug_log[] = 'already connected!';
            $failures++;
            if($failures > 10000) {
                break;
            }
            continue;
        }
        $v1 = $junctions[$con['j1']]['circuit'];
        $v2 = $junctions[$con['j2']]['circuit'];
        $final_connection = $junctions[$con['j1']][0] * $junctions[$con['j2']][0];
        for($i = 0; $i < sizeof($junctions); $i++) {
            if($junctions[$i]['circuit'] == $v2) {
                $debug_log[] = "set {$v2} to {$v1}";
                $junctions[$i]['circuit'] = $v1;
                if($no_connections <= REQ_CONS) {
                    $junctions_2[$i]['circuit'] = $v1;
                }
            }
        }
    }

    $debug_log[] = var_export(array_map(fn ($arr) => $arr['circuit'], $junctions), true);
    $debug_log[] = var_export($junctions[19], true);

    $networks = [];
    for($i = 0; $i < sizeof($junctions_2); $i++) {
        $debug_log[] = $i.": ".var_export($junctions_2[$i], true);
        $networks[$junctions_2[$i]['circuit']]++;
    }

    $debug_log[] = var_export($networks, true);

    sort($networks);
    $debug_log[] = var_export($networks, true);
    $debug_log[] = array_sum($networks);

    $total_size = 1;
    for($i = 0; $i < 3; $i++) {
        $nw = array_pop($networks);
        $total_size *= $nw;
    }

    return [
        'Part1' => $total_size,
        'Part2' => $final_connection,
        'Debug' => $debug_log,
    ];

}

?>