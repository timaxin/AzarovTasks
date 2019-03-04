<?php

$initMatrixFirst = [[2.7, 3.3, 1.3], [3.5, -1.7, 2.8], [4.1, 5.8, -1.7]];
$initMatrixSecond = [[3.8, 6.7, -1.2], [6.4, 1.3, -2.7], [2.4, -4.5, 3.5]];
$valueColumn = [2.1, 1.7, 0.8];
$multiplierK = 1.1;
$multiplierN = 0.7;

$initMatrix = [[], [], []];
for ($i = 0; $i < 3; $i++) {
    for ($j = 0; $j < 3; $j++) {
        $initMatrix[$i][] = $multiplierK * $initMatrixFirst[$i][$j] + $multiplierN * $initMatrixSecond[$i][$j];
        echo $initMatrix[$i][$j] . "<span style='font-size: 16px; line-height: 20px'>x</span>" .
            "<span style='font-size: 10px; margin-right: 5px'>" . ($j + 1) . "</span>";
    }
    echo "<span> = " . $valueColumn[$i] . "</span>" . '<br><br>';
}

for ($i = 0; $i < 3; $i++) {
    for ($j = 0; $j < 3; $j++) {
        if ($i === $j && checkMethodRule($initMatrix[$i], $initMatrix[$i][$j])) {
            while (checkMethodRule($initMatrix[$i], $initMatrix[$i][$j])) {
            }
        }
        echo $initMatrix[$i][$j] . "<span style='font-size: 16px; line-height: 20px'>x</span>" .
            "<span style='font-size: 10px; margin-right: 5px'>" . ($j + 1) . "</span>";
    }
    echo "<span> = " . $valueColumn[$i] . "</span>" . '<br><br>';
}

function absoluteSumOfRow(Array $array):Int {
    $sum = 0;
    foreach ($array as $item) {
        $sum += abs($item);
    }
    return $sum;
}

function checkMethodRule(Array $array, $elem):Bool {
    return $elem !== max($array) && (absoluteSumOfRow($array) - abs($elem)) > abs($elem);
}

function arrayAdd(Array $first, Array $second):Array {
    $result = [];
    for ($i = 0; $i < count($first); $i++) {
        $result[] = $first[$i] + $second[$i];
    }
    return $result;
}