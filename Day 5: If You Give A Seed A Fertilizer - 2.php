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

$seedsRange = [];
for ($i = 0; $i < count($seeds) / 2; $i++) {
    $seedsRange[] = [
        $seeds[$i * 2],
        $seeds[$i * 2] + $seeds[$i * 2 + 1],
    ];
}

$mapsRange = [];
foreach ($maps as $key => $map) {
    $mapsRange[$key] = [];
    foreach ($map as $row) {
        $mapsRange[$key][] = [
            $row[1], // Start range
            $row[1] + $row[2] - 1, // End range
            $row[0] - $row[1], // Diff to map
        ];
    }
    // Order by start
    usort($mapsRange[$key], function($a, $b) {
        return $a[0] - $b[0];
    });
}


function mapRecursive($ranges, $row, $deep = 0) {
    echo "opa";
    $mapped = [];
    $splitRanges = [];

    if (count($ranges) == 0) {
        return [];
    }

    if ($deep > 10) {
        return [];
    }

    foreach($ranges as $seedRange) {
        $A = $seedRange[0];
        $B = $seedRange[1];

        $C = $row[0];
        $D = $row[1];
        $mapDiff = $row[2];

        if ($A >= $C && $B <= $D) {
            $mapped[] = [
                $A + $mapDiff,
                $B + $mapDiff,
            ];
            continue;
        }

        if ($A < $C && $B > $D) {
            $splitRanges[] = [
                $A,
                $C,
            ];
            $splitRanges[] = [
                $D,
                $B,
            ];
            $mapped[] = [
                $C + $mapDiff,
                $D + $mapDiff,
            ];
            continue;
        }

        if ($A < $C && $B >= $C && $B < $D) {
            $splitRanges[] = [
                $A,
                $C,
            ];

            $mapped[] = [
                $C + $mapDiff,
                $B + $mapDiff,
            ];
            continue;
        }

        if ($A >= $C && $A < $D && $B > $D) {
            $mapped[] = [
                $A + $mapDiff,
                $D + $mapDiff,
            ];

            $splitRanges[] = [
                $D,
                $B,
            ];
            continue;
        }

        if ($B < $C || $A > $D) {
            $splitRanges[] = [
                $A,
                $B,
            ];
        }
    }

    $mapped = array_merge($mapped, mapRecursive($splitRanges, $row, $deep + 1));

    return $mapped;
}


foreach($mapsRange as $key => $map) {
    $newSeedsRanges = [];
    foreach($map as $row) {
        $newSeedsRanges = array_merge($seedsRange, mapRecursive($seedsRange, $row));

        $seedsRange = $newSeedsRanges;
        $newSeedsRanges = [];
    }
}

$result = PHP_INT_MAX;
foreach($seedsRange as $seedRange) {
    $result = min($result, $seedRange[0]);
}

echo $result . PHP_EOL;

//print_r($mapsRange);

