<?php

$times = fgets(STDIN);
$distances = fgets(STDIN);

$t = implode('', array_values(array_filter(explode(' ', trim(explode(':', $times)[1])))));
$d = implode('', array_values(array_filter(explode(' ', trim(explode(':', $distances)[1])))));

function calculaBhaskara($a, $b, $c) {
    $delta = pow($b, 2) - 4 * $a * $c;

    if ($delta < 0) {
        throw new Exception('Não há solução real para a equação porque o delta é negativo.');
    }

    $x1 = (-$b + sqrt($delta)) / (2 * $a);
    $x2 = (-$b - sqrt($delta)) / (2 * $a);

    return [$x1, $x2];
}

list($x1, $x2) = calculaBhaskara(1, -$t, $d);
$diff = abs(floor($x1) - floor($x2));

echo $diff . PHP_EOL;

