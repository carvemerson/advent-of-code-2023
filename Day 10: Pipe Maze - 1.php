<?php

$maze = [];
while($input = fgets(STDIN)) {
    $input = str_split(trim($input));
    $maze[] = $input;
}

function isValidPosition($i, $j) {
    global $maze;

    if ($i < 0 || $j < 0 || $i >= count($maze) || $j >= count($maze[0])) {
        return false;
    }

    return true;
}

function getNextStep($i, $j, $pipe) {
    global $maze;

    if (!isValidPosition($i, $j)) {
        return false;
    }

    if ($pipe == 'S') {
        $right = !isValidPosition($i, $j+1) ?: $maze[$i][$j + 1];
        $left = !isValidPosition($i, $j - 1) ?: $maze[$i][$j - 1];
        $top = !isValidPosition($i - 1, $j) ?: $maze[$i - 1][$j];
        $bottom = !isValidPosition($i + 1, $j) ?: $maze[$i + 1][$j];

        if ($right === '7' || $right === 'J' || $right === '-') {
            return [$i, $j + 1];
        }

        if ($left === 'L' || $left === 'F' || $left === '-') {
            return [$i, $j - 1];
        }

        if ($top === '7' || $top === 'F' || $top === '|') {
            return [$i - 1, $j];
        }

        if ($bottom === 'L' || $bottom === 'J' || $bottom === '|') {
            return [$i + 1, $j];
        }
    }

    if ($pipe == 'F') {
        $right = $maze[$i][$j + 1];
        $down = $maze[$i + 1][$j];

        if ($right === '7' || $right === 'J' || $right === '-') {
            return [$i, $j + 1];
        }

        if ($down === 'L' || $down === 'J' || $down === '|') {
            return [$i + 1, $j];
        }
    }

    if ($pipe == 'L') {
        $right = $maze[$i][$j + 1];
        $top = $maze[$i - 1][$j];

        if ($right === '7' || $right === 'J' || $right === '-') {
            return [$i, $j + 1];
        }

        if ($top === '7' || $top === 'F' || $top === '|') {
            return [$i - 1, $j];
        }
    }

    if ($pipe == '7') {
        $left = $maze[$i][$j - 1];
        $bottom = $maze[$i + 1][$j];

        if ($left === 'L' || $left === 'F' || $left === '-') {
            return [$i, $j - 1];
        }

        if ($bottom === 'L' || $bottom === 'J' || $bottom === '|') {
            return [$i + 1, $j];
        }
    }

    if ($pipe == 'J') {
        $left = $maze[$i][$j - 1];
        $top = $maze[$i - 1][$j];

        if ($left === 'L' || $left === 'F' || $left === '-') {
            return [$i, $j - 1];
        }

        if ($top === '7' || $top === 'F' || $top === '|') {
            return [$i - 1, $j];
        }
    }

    if ($pipe == '-') {
        $right = $maze[$i][$j + 1];
        $left = $maze[$i][$j - 1];

        if ($right === '7' || $right === 'J' || $right === '-') {
            return [$i, $j + 1];
        }

        if ($left === 'L' || $left === 'F' || $left === '-') {
            return [$i, $j - 1];
        }
    }

    if ($pipe == '|') {
        $top = $maze[$i - 1][$j];
        $bottom = $maze[$i + 1][$j];

        if ($top === '7' || $top === 'F' || $top === '|') {
            return [$i - 1, $j];
        }

        if ($bottom === 'L' || $bottom === 'J' || $bottom === '|') {
            return [$i + 1, $j];
        }
    }

    return false;
}

function findFirstPosition() {
    global $maze;

    for($i = 0; $i < count($maze); $i++) {
        for($j = 0; $j < count($maze[$i]); $j++) {
            if ($maze[$i][$j] === 'S') {
                return [$i, $j];
            }
        }
    }

    throw new Exception('Invalid maze');
}

list($s1p, $s2p) = findFirstPosition();
$p1 = $s1p;
$p2 = $s2p;

$count = 0;
while(true) {
    $direction = $maze[$p1][$p2];
    $maze[$p1][$p2] = 'X';

    echo $direction;

    $next = getNextStep($p1, $p2, $direction);

    $count++;
    if ($next === false) {
        break;
    } else {
        list($p1, $p2) = $next;
    }
}

echo PHP_EOL;
echo ceil($count/2) . PHP_EOL;
