<?php

$histories = [];
while($input = fgets(STDIN)) {
    $input = trim($input);
    $input = explode(' ', $input);
    $input = array_filter($input, fn($value) => $value !== '');
    $histories[] = $input;
}

function getNextOfSequency($history) {
    $last = $history[count($history)-1];
    $valuesCount = array_count_values($history);

    if (isset($valuesCount[0])) {
        $zeros = $valuesCount[0];

        if ($zeros === count($history)) {
            return 0;
        }
    }

    $newHistory = [];
    for($i = 0; $i < count($history)-1; $i++) {
        $newHistory[] = $history[$i+1] - $history[$i];
    }

    return $last + getNextOfSequency($newHistory);
}


$result = 0;
foreach($histories as $history) {
    $result += getNextOfSequency($history);
}

echo $result . PHP_EOL;
