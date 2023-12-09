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


$target = 'AAA';
$i = 0;
$iterations = 0;
while($target != 'ZZZ') {
    list($left, $right) = $leftRight[$target];
    $direction = $instructions[$i];

    if($direction === 'L') {
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

echo $iterations . PHP_EOL;
