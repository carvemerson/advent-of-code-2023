<?php

$rows = [];
$sec = [];

while ($input = fgets(STDIN)) {
    list($a, $b) = explode(' ', trim($input));
    $rows[] = $a;
    $sec[] = explode(',', $b);
}

function checkRow($row, &$sec) {
    $split = array_values(array_filter(explode('.', $row)));

    if (count($split) != count($sec)) {
        return false;
    }

    foreach($split as $key => $value) {
        if (strlen($value) != $sec[$key]) {
            return false;
        }
    }

    return true;
}

function countPossibilities($row, &$sec, $i=0) {

    if ($i < strlen($row)) {
        while($i < strlen($row) && $row[$i] != '?') {
            $i++;
        }

        if ($i < strlen($row) && $row[$i] == '?') {
            $row[$i] = '.';
            $p1 = countPossibilities($row, $sec, $i);
            $row[$i] = '#';
            $p2 = countPossibilities($row, $sec, $i);

            return $p1 + $p2;
        }
    }

    if (checkRow($row, $sec)) {
        return 1;
    }

    return 0;
}


$result = 0;
foreach($rows as $key => $row) {
    $result += countPossibilities($row, $sec[$key]);
}

echo $result . PHP_EOL;
