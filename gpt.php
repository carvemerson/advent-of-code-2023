<?php

function isSymbol($char) {
    // Define the symbols that are considered as part of the engine schematic
    $symbols = ['*', '+', '#', '$'];

    // Check if the character is a symbol
    return in_array($char, $symbols);
}

function isPartNumber($grid, $row, $col) {
    // Check if the given position contains a number and is adjacent to a symbol
    return is_numeric($grid[$row][$col]) && (
            isSymbol($grid[$row - 1][$col - 1]) ||
            isSymbol($grid[$row - 1][$col]) ||
            isSymbol($grid[$row - 1][$col + 1]) ||
            isSymbol($grid[$row][$col - 1]) ||
            isSymbol($grid[$row][$col + 1]) ||
            isSymbol($grid[$row + 1][$col - 1]) ||
            isSymbol($grid[$row + 1][$col]) ||
            isSymbol($grid[$row + 1][$col + 1])
        );
}

function sumPartNumbers($grid) {
    $sum = 0;
    $rows = count($grid);
    $cols = strlen($grid[0]);

    // Iterate through the grid and calculate the sum of part numbers
    for ($i = 0; $i < $rows; $i++) {
        for ($j = 0; $j < $cols; $j++) {
            if (isPartNumber($grid, $i, $j)) {
                $sum += intval($grid[$i][$j]);
            }
        }
    }

    return $sum;
}

// Your engine schematic
$engineSchematic = [
    "467..114..",
    "...*......",
    "..35..633.",
    "......#...",
    "617*......",
    ".....+.58.",
    "..592.....",
    "......755.",
    "...$.*....",
    ".664.598.."
];

// Calculate the sum of part numbers
$result = sumPartNumbers($engineSchematic);

// Output the result
echo "The sum of all part numbers in the engine schematic is: $result\n";

?>
