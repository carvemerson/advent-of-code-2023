<?php

$universe = [];
while($line = fgets(STDIN)) {
    $universe[] = trim($line);

    // Expand row
    if (!substr_count($line, '#')) {
        $universe[] = trim($line);
    }
}

// Expand column
for($j=0; $j < strlen($universe[0]); $j++) {
    $expand = true;
    for($i = 0; $i < count($universe); $i++) {
        if ($universe[$i][$j] == '#') {
            $expand = false;
            break;
        }
    }

    if ($expand) {
        for($i = 0; $i < count($universe); $i++) {
            $universe[$i] = substr_replace($universe[$i], '.', $j, 0);
        }
        $j++;
    }
}

foreach($universe as $v) {
    echo $v . PHP_EOL;
}

$galaxies = [];
for($i = 0; $i < count($universe); $i++) {
    for($j = 0; $j < strlen($universe[$i]); $j++) {
        if ($universe[$i][$j] == '#') {
            $galaxies[] = [$i, $j];
        }
    }
}

$result = 0;
foreach($galaxies as $k1 => $gFrom) {
    $fromI = $gFrom[0];
    $fromJ = $gFrom[1];

    foreach($galaxies as $k2 => $gTo) {
        $toI = $gTo[0];
        $toJ = $gTo[1];

        $result += abs($fromI - $toI) + abs($fromJ - $toJ) ;
    }
}

echo $result / 2 . PHP_EOL;
