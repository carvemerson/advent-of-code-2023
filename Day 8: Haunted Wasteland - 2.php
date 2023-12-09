<?php

$instructions = str_split(trim(fgets(STDIN)));
fgets(STDIN); // Skip empty line


$leftRight = [];
while($input = fgets(STDIN)) {
    $input = str_replace(' ', '', trim($input));
    $input = str_replace('(', '', trim($input));
    $input = str_replace(')', '', trim($input));
    $input = str_replace('=', ',', trim($input));

    list($key, $left, $right) = explode(',', $input);
    $leftRight[$key] = [$left, $right];
}

function getStartTargets() {
    global $leftRight;
    $keys = array_keys($leftRight);

    $result = [];
    foreach($keys as $key) {
        if (str_ends_with($key, 'A')) {
            $result[] = $key;
        }
    }

    return $result;
}


$targets = getStartTargets();
$counts = [];
foreach($targets as $target) {

    $i = 0;
    $iterations = 0;
    while(!str_ends_with($target, 'Z')) {
        list($left, $right) = $leftRight[$target];
        $direction = $instructions[$i];

        if($direction == 'L') {
            $target = $left;
        } else {
            $target = $right;
        }

        $i++;
        $iterations++;
        if ($i === count($instructions)) {
            $i = 0;
        }
    }

    $counts[] = $iterations;
}

function gcd($a, $b) {
    while ($b != 0) {
        $temp = $b;
        $b = $a % $b;
        $a = $temp;
    }
    return $a;
}

function lcm($a, $b) {
    return abs($a * $b) / gcd($a, $b);
}

function calculate_lcm($numbers) {
    $result = 1;
    foreach ($numbers as $number) {
        $result = lcm($result, $number);
    }
    return $result;
}

print_r(calculate_lcm($counts));



