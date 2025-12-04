<?php

function read_map(string $data) {
    $rows = preg_split('/$\R?^/m', $data);
    $width = strlen($rows[0]);
    $height = sizeof($rows);
    return [
        "data" => $rows,
        "width" => $width,
        "height" => $height,
    ];
}

function map_get_val_at(array $map, int $x, int $y) {
    if($x < 0 || $y < 0 || $x >= $map["width"] || $y >= $map["height"]) {
        return NULL;
    }
    return $map["data"][$y][$x];
}

function map_set_val_at(array &$map, int $x, int $y, string $val) {
    if($x < 0 || $y < 0 || $x >= $map["width"] || $y >= $map["height"]) {
        return NULL;
    }
    $map["data"][$y][$x] = $val;
}

?>