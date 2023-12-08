<?php

$seeds = [];
$maps = [];
$key = '';
while($line = fgets(STDIN)) {
    $input = trim($line);

    if (empty($input)) {
        continue;
    }

    if (strpos($input, 'seeds:') !== false) {
        $parts = explode(': ', $input);
        $seeds = explode(' ', $parts[1]);
        continue;
    }

    if (strpos($input, 'map:') !== false) {
        $key = $input;
        continue;
    }

    $maps[$key][] = explode(' ', $input);
}

$minLocation = PHP_INT_MAX;
foreach ($seeds as $seed) {
    $mappedTo = $seed;

    foreach ($maps as $map) {
        foreach ($map as $row) {
            if ($mappedTo >= $row[1] && $mappedTo < $row[1] + $row[2]) {
                $diff = $mappedTo - $row[1];
                $mappedTo = $row[0] + $diff;
                break;
            }
        }
    }
    $minLocation = min($minLocation, $mappedTo);
}

echo $minLocation . PHP_EOL;
