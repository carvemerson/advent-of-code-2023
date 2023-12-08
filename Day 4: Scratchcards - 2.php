<?php

$input = require __DIR__ . '/Day 4 input.php';

$copies = array_fill(1, count($input), 1);
$result = 0;

$i = 1;
foreach($input as $card) {
    [$a1, $a2] = explode('|', explode(':', $card)[1]);

    $a1 = array_filter(explode(' ', trim($a1)), fn($v) => !empty($v));
    $a2 = array_filter(explode(' ', trim($a2)), fn($v) => !empty($v));

    $maches = count(array_intersect($a1, $a2));

    for($j = 0; $j < $maches; $j++) {
        $copies[$j + $i + 1] += $copies[$i];
    }

    $i++;
}

echo array_sum($copies) . PHP_EOL;
