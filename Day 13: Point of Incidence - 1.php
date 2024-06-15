<?php

$puzzles = [];
$puzzle = [];
while($line = fgets(STDIN)) {
    $line = trim($line);

    if (empty($line)) {
        $puzzles[] = $puzzle;
        $puzzle = [];
        continue;
    }

    $puzzle[] = $line;
}
$puzzles[] = $puzzle;

function solve($p) {
    $i = 0;
    $j = count($p) - 1;

    if ($p[$i] != $p[$j]) {
        $i = 1;
    }

    if ($p[$i] != $p[$j]) {
        $i = 0;
        $j = count($p) - 2;
    }

    $count = 1;

    while($i < $j) {
        if ($p[$i] != $p[$j]) {
            break;
        }

        $i++;
        $j--;
        $count ++;
    }

    if ($j < $i) {
        return $count;
    }

    return 0;
}

function transpose($inputArray) {
    $rows = count($inputArray);
    $cols = strlen($inputArray[0]); // Assuming all rows have equal length

    $transposedArray = [];
    for ($col = 0; $col < $cols; $col++) {
        $transposedArray[$col] = "";
        for ($row = 0; $row < $rows; $row++) {
            $transposedArray[$col] .= $inputArray[$row][$col];
        }
    }

    return $transposedArray;
}

$result = 0;
foreach($puzzles as $p) {
    $s = 100 * solve($p);

    if (!$s) {
        $p = transpose($p);
        $s = solve($p);
    }

    $result += $s;
}

echo $result . PHP_EOL;
