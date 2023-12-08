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
        $seeds[$i * 2] + $seeds[$i * 2 + 1] - 1,
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

function getIntersection($a, $b, $c, $d) {
    if ($a > $d || $b < $c) {
        return [];
    }

    return [
        max($a, $c),
        min($b, $d),
    ];
}

function getDiffLeft($a, $b, $c, $d) {
    if ($a >= $c) {
        return [];
    }

    return [
        $a,
        min($c - 1, $b),
    ];
}

function getDiffRight($a, $b, $c, $d) {
    if ($b <= $d) {
        return [];
    }

    return [
        max($d + 1, $a),
        $b,
    ];
}

$result = PHP_INT_MAX;
foreach($seedsRange as $seedRange) {
    $rangesToProcess = [
        $seedRange,
    ];

    foreach ($mapsRange as $key => $maps) {
        echo $key . "\n";
        foreach($rangesToProcess as $seedToBeProcessed) {
            $a = $seedToBeProcessed[0];
            $b = $seedToBeProcessed[1];
            echo "seed to be processed $a $b\n";

            // Process the ranges (maps
            $i = 0;
            foreach ($maps as $map) {
                $shouldStop = true;
                $c = $map[0];
                $d = $map[1];
                $diff = $map[2];
                // Mapped, add the diff to the seed
                $intersection = getIntersection($a, $b, $c, $d);
                if (!empty($intersection)) {
                    $intersection = [
                        $intersection[0] + $diff,
                        $intersection[1] + $diff,
                    ];
                    $newSeeds[] = $intersection;
                    echo "new seed $intersection[0] $intersection[1]\n";
                }

                // Not mapped and on the left, there is no range to add, repeat the seed
                $diffLeft = getDiffLeft($a, $b, $c, $d);
                if (!empty($diffLeft)) {
                    $newSeeds[] = $diffLeft;
                    echo "new seed $diffLeft[0] $diffLeft[1]\n";
                }

                // Not mapped and on the right, we can have a range to map, so add it
                $diffRight = getDiffRight($a, $b, $c, $d);
                if (!empty($diffRight)) {
                    $shouldStop = false;
                    $a = $diffRight[0];
                    $b = $diffRight[1];
                    if ($i == count($maps) - 1) {
                        $newSeeds[] = [
                            $a,
                            $b,
                        ];
                    }
                    echo "new seed $a $b\n";
                }

                if ($shouldStop) {
                    break;
                }

                $i++;
            }
        }
        $rangesToProcess = $newSeeds;
        $newSeeds = [];
    }
    echo "*************** END SEED ***************\n";

    foreach ($rangesToProcess as $seedToBeProcessed) {
        $result = min($result, $seedToBeProcessed[0]);
    }
}

echo $result . "\n";
