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
        'J' => 0,
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

function getValueForCard($card) {
    if (isFiveOfAKind($card)) {
        return 7;
    } elseif (isFourOfAKind($card)) {
        return 6;
    } elseif (isFullHouse($card)) {
        return 5;
    } elseif (isThreeOfAKind($card)) {
        return 4;
    } elseif (isTwoPairs($card)) {
        return 3;
    } elseif (isOnePair($card)) {
        return 2;
    } elseif (isHighCard($card)) {
        return 1;
    }
}


foreach($hands as $card => $value) {

    $possibleJValues = ['A', 'K', 'Q', 'T', 9, 8, 7, 6, 5, 4, 3, 2, 'J'];

    $hands[$card]['type'] = PHP_INT_MIN;
    foreach($possibleJValues as $j) {
        $newCard = str_replace('J', $j, $card);
        $hands[$card]['type'] = max($hands[$card]['type'], getValueForCard($newCard));
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
    $result += $hand['bid'] * $i;
    $i++;
}

echo $result . PHP_EOL;
