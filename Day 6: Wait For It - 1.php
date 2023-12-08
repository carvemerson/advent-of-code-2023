<?php

$times = fgets(STDIN);
$distances = fgets(STDIN);

$times = array_values(array_filter(explode(' ', trim(explode(':', $times)[1]))));
$distances = array_values(array_filter(explode(' ', trim(explode(':', $distances)[1]))));

$result = 1;
foreach($times as $key => $time) {
    $disntance = $distances[$key];

    $win = 0;
    for($i=1; $i<=$time; $i++) {
        $calc = ($time - $i) * $i;

        if ($calc > $disntance) {
            $win++;
        }
    }

    $result = $result * $win;
}

echo $result . PHP_EOL;
