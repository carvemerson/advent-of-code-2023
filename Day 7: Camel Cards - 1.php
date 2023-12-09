<?php

$hands = [];
while($input = fgets(STDIN)) {
    list($hand, $value) = explode(' ', trim($input));
    $hands[$hand]['bid'] = $value;
    $hands[$hand]['hand'] = $hand;
}


function isFiveOfAKind($cards) {
    $countedValues = array_unique(str_split($cards));
    return count($countedValues) === 1;
}

function isFourOfAKind($cards) {
    $cardValues = array_count_values(str_split($cards));
    foreach($cardValues as $value) {
        if($value === 4) {
            return true;
        }
    }
    return false;
}

function isFullHouse($cards) {
    $values = str_split($cards);
    $uniqueValues = array_unique($values);

    if (count($uniqueValues) !== 2) {
        return false;
    }

    $uniqueValues = array_values($uniqueValues);  // Re-index array

    $c1 = substr_count($cards, $uniqueValues[0]);
    $c2 = substr_count($cards, $uniqueValues[1]);

    return ($c1 === 2 && $c2 === 3) || ($c1 === 3 && $c2 === 2);
}

function isThreeOfAKind($cards) {
    $cardValues = array_count_values(str_split($cards));
    foreach($cardValues as $value) {
        if($value === 3) {
            return true;
        }
    }
    return false;
}

function isTwoPairs($cards) {
    $cardValues = str_split($cards);
    $distinctValues = array_unique($cardValues);
    return count($distinctValues) === 3;
}

function isOnePair($cards) {
    $cardValues = str_split($cards);
    $distinctValues = array_unique($cardValues);
    return count($distinctValues) === 4;
}


function isHighCard($cards) {
    $cardValues = str_split($cards);
    $distinctValues = array_unique($cardValues);
    return count($distinctValues) === 5;
}

function tieBreaker($card1, $card2) {
    $map = [
        'A' => 13,
        'K' => 12,
        'Q' => 11,
        'J' => 10,
        'T' => 9,
        9 => 8,
        8 => 7,
        7 => 6,
        6 => 5,
        5 => 4,
        4 => 3,
        3 => 2,
        2 => 1,
    ];

    $c1 = str_split($card1);
    $c2 = str_split($card2);

    for($i = 0; $i < count($c1); $i++) {
        if ($map[$c1[$i]] > $map[$c2[$i]]) {
            return 1;
        } elseif ($map[$c1[$i]] < $map[$c2[$i]]) {
            return -1;
        }
    }

    return 0;
}

foreach($hands as $card => $value) {
    if (isFiveOfAKind($card)) {
        $hands[$card]['type'] = 7;
    } elseif (isFourOfAKind($card)) {
        $hands[$card]['type'] = 6;
    } elseif (isFullHouse($card)) {
        $hands[$card]['type'] = 5;
    } elseif (isThreeOfAKind($card)) {
        $hands[$card]['type'] = 4;
    } elseif (isTwoPairs($card)) {
        $hands[$card]['type'] = 3;
    } elseif (isOnePair($card)) {
        $hands[$card]['type'] = 2;
    } elseif (isHighCard($card)) {
        $hands[$card]['type'] = 1;
    }
}

// sort
usort($hands, function($a, $b) {
    if ($a['type'] > $b['type']) {
        return 1;
    } elseif ($a['type'] < $b['type']) {
        return -1;
    } else {
        return tieBreaker($a['hand'], $b['hand']);
    }
});

$result = 0;
$i = 1;
foreach($hands as $hand) {
    echo $hand['bid'] . PHP_EOL;
    $result += $hand['bid'] * $i;
    $i++;
}

echo $result . PHP_EOL;
