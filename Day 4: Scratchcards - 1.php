<?php

$input = require __DIR__ . '/Day 4 input.php';

$result = 0;
foreach($input as $card) {
    [$a1, $a2] = explode('|', explode(':', $card)[1]);

    $a1 = array_filter(explode(' ', trim($a1)), fn($v) => !empty($v));
    $a2 = array_filter(explode(' ', trim($a2)), fn($v) => !empty($v));

    $pow = count(array_intersect($a1, $a2));

    if ($pow == 1) {
        $result += 1;
    } else if($pow > 1) {
        $result += pow(2, $pow - 1);
    }
}

echo $result . PHP_EOL;
