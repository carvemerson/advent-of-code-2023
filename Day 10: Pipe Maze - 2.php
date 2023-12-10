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

function overwriteS($i, $j) {
    global $maze;

    $right = !isValidPosition($i, $j+1) ?: in_array($maze[$i][$j + 1], ['-', '7', 'J']);
    $left = !isValidPosition($i, $j-1) ?: in_array($maze[$i][$j - 1], ['-', 'F', 'L']);
    $top = !isValidPosition($i-1, $j) ?: in_array($maze[$i-1][$j], ['|', 'F', '7']);
    $bottom =  !isValidPosition($i+1, $j) ?: in_array($maze[$i+1][$j], ['|', 'J', 'L']);

    if ($right && $left) {
        $maze[$i][$j] = '-';
    }

    if ($top && $bottom) {
        $maze[$i][$j] = '|';
    }

    if ($top && $right) {
        echo $top . ' ' .  $right;
        $maze[$i][$j] = 'L';
    }

    if ($top && $left) {
        $maze[$i][$j] = 'J';
    }

    if ($bottom && $left) {
        $maze[$i][$j] = '7';
    }

    if ($bottom && $right) {
        $maze[$i][$j] = 'F';
    }
}

list($s1p, $s2p) = findFirstPosition();
overwriteS($s1p, $s2p);
$p1 = $s1p;
$p2 = $s2p;

$count = 0;
$originalMaze = $maze;
while(true) {
    $direction = $maze[$p1][$p2];

    $maze[$p1][$p2] = 'X';

    $next = getNextStep($p1, $p2, $direction);

    $count++;
    if ($next === false) {
        break;
    } else {
        list($p1, $p2) = $next;
    }
}

$result = 0;
for($i = 0; $i < count($maze); $i++) {
    $isIn = false;
    $lastCorner = '';
    for($j = 0; $j < count($maze[$i]); $j++) {
        if ($maze[$i][$j] === 'X') {
            if ($originalMaze[$i][$j] === '|') {
                $isIn = !$isIn;
            } else {
                if ($lastCorner == 'F' && $originalMaze[$i][$j] == 'J') {
                    $isIn = !$isIn;
                    $lastCorner = '';
                } else if ($lastCorner == 'L' && $originalMaze[$i][$j] == '7') {
                    $isIn = !$isIn;
                    $lastCorner = '';
                } else if ($originalMaze[$i][$j] == 'L' || $originalMaze[$i][$j] == 'F') {
                    $lastCorner = $originalMaze[$i][$j];
                }
            }
        } else {
            if ($isIn) {
                $maze[$i][$j] = 1;
                $result++;
            } else {
                $maze[$i][$j] = 0;
            }
        }
    }
}

foreach($maze as $row) {
    echo implode('', $row) . PHP_EOL;
}

echo "\n";

foreach($originalMaze as $row) {
    echo implode('', $row) . PHP_EOL;
}

echo $result . PHP_EOL;
