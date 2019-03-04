<?php

$initMatrixFirst = [[2.7, 3.3, 1.3], [3.5, -1.7, 2.8], [4.1, 5.8, -1.7]];
$initMatrixSecond = [[3.8, 6.7, -1.2], [6.4, 1.3, -2.7], [2.4, -4.5, 3.5]];
$valueColumn = [2.1, 1.7, 0.8];
$multiplierK = 1.1;
$multiplierN = 0.7;

$initMatrix = [[], [], []];
for ($i = 1; $i < 4; $i++) {
    for ($j = 1; $j < 4; $j++) {
        $initMatrix[$i - 1][] = $multiplierK * $initMatrixFirst[$i - 1][$j - 1] + $multiplierN * $initMatrixSecond[$i - 1][$j - 1];
        echo $initMatrix[$i - 1][$j - 1] . "<span style='font-size: 16px; line-height: 20px'>x</span>" . "<span style='font-size: 10px'>" . $i . $j . "</span>";
    }
    echo '<br><br>';
}