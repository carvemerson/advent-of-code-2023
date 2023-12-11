<?php

$universe = [];
while($line = fgets(STDIN)) {
    if (!substr_count($line, '#')) {
        $universe[] = str_repeat('!', strlen(trim($line)));
    } else {
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
            $universe[$i] = substr_replace($universe[$i], '!', $j, 1);
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
    foreach($galaxies as $k2 => $gTo) {
        $fromI = $gFrom[0];
        $fromJ = $gFrom[1];
        $toI = $gTo[0];
        $toJ = $gTo[1];

        while($fromI != $toI || $fromJ != $toJ) {
            if ($fromI < $toI) {
                $fromI++;
            } else if ($fromI > $toI) {
                $fromI--;
            } else if ($fromJ < $toJ) {
                $fromJ++;
            } else if ($fromJ > $toJ) {
                $fromJ--;
            }

            if ($universe[$fromI][$fromJ] == '!') {
                $result+=1000000;
            } else {
                $result+=1;
            }
        }
    }
}

echo $result / 2 . PHP_EOL;
