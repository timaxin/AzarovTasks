<?php

$initMatrixFirst = [[2.7, 3.3, 1.3], [3.5, -1.7, 2.8], [4.1, 5.8, -1.7]];
$initMatrixSecond = [[3.8, 6.7, -1.2], [6.4, 1.3, -2.7], [2.4, -4.5, 3.5]];
$valueColumn = [2.1, 1.7, 0.8];
$multiplierK = 1.1;
$multiplierN = 0.7;

$initMatrix = [[], [], []];

for ($i = 0; $i < 3; $i++) {
    for ($j = 0; $j < 3; $j++) {
        $initMatrix[$i][] = $multiplierK * $initMatrixFirst[$i][$j] + $multiplierN * $initMatrixSecond[$i][$j]; // Считаем изначальную матрицу
    }
}

outputMatrix($initMatrix, $valueColumn);

$initMatrix[0] = add($initMatrix[0], $initMatrix[1]); //Складываем первую строку со второй
$valueColumn[0] = round($valueColumn[0] + $valueColumn[1], 4);
//
$initMatrix[1] = subtract($initMatrix[1], $initMatrix[0]); //Вычитаем первую строку из второй
$valueColumn[1] = round($valueColumn[1] - $valueColumn[0],4);
//
$initMatrix[0] = add($initMatrix[0], $initMatrix[1]); //Складываем первую строку со второй
$valueColumn[0] = round($valueColumn[0] + $valueColumn[1], 4);
//
$initMatrix[2] = subtract($initMatrix[2], $initMatrix[0]); //Вычитаем первую строку из третьей
$valueColumn[2] = round($valueColumn[2] - $valueColumn[0], 4);
//
$initMatrix[2] = multiplyAndAdd($initMatrix[1], $initMatrix[2], 0.5); //Умножаем вторую строку на 0.5 и складываем с третьей
$valueColumn[2] = round($valueColumn[1] * 0.5 + $valueColumn[2], 4);
//
$initMatrix[2] = multiplyAndAdd($initMatrix[0], $initMatrix[2], (4.955 / 8.33)); //Умножаем первую строку на (4.955 / 8.33) и складываем с третьей
$valueColumn[2] = round($valueColumn[0] * (4.955 / 8.33) + $valueColumn[2], 4);
//
$initMatrix[1] = add($initMatrix[0], $initMatrix[1]); //Складываем первую строку со второй
$valueColumn[1] = round($valueColumn[0] + $valueColumn[1], 4);
//
$initMatrix[1] = multiplyAndAdd($initMatrix[2], $initMatrix[1], -12); //Умножаем третью строку на -12 и складываем со второй
$valueColumn[1] = round($valueColumn[2] * -12 + $valueColumn[1], 4);
//
$initMatrix[2] = subtract($initMatrix[2], $initMatrix[1]); //Вычитаем вторую строку из третьей
$valueColumn[2] = round($valueColumn[2] - $valueColumn[1], 4);
//
$initMatrix[1] = add($initMatrix[1], $initMatrix[2]); //Складываем вторую строку с третьей
$valueColumn[1] = round($valueColumn[1] + $valueColumn[2], 4);
//
$initMatrix[2] = multiplyAndAdd($initMatrix[0], $initMatrix[2], 0.25); //Умножаем первую строку на 0.25 и складываем с третьей
$valueColumn[2] = round($valueColumn[0] * 0.25 + $valueColumn[2], 4);

outputMatrix($initMatrix, $valueColumn);

$xColumn = [$initMatrix[0][0], $initMatrix[1][1], $initMatrix[2][2]];
$asideMatrix = getAsideMatrix($initMatrix, $valueColumn, $xColumn);

outputAsideMatrix($asideMatrix);

$xColumnNew = [$asideMatrix[0][2], $asideMatrix[1][2], $asideMatrix[2][2]];
$i = 0;
do {
    $xColumnPrev = $xColumnNew;
    $tempMatrix = getNewMatrix($asideMatrix, $xColumnPrev);
    $xColumnNew = getNewXColumn($tempMatrix);
    $i++;
    echo ' - ' . ($i) . '-ая итерация<br><br>';
} while(checkIfNotEqual($xColumnPrev, $xColumnNew));

echo 'Ответ: X1= ' . $xColumnNew[0] . '; X2 = ' . $xColumnNew[1] . '; X3 = ' . $xColumnNew[2] . '<br>';

function outputMatrix($matrix, $valueColumn) { // Вывод матрицы
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            echo $matrix[$i][$j] . "<span style='font-size: 16px; line-height: 20px'>x</span>" .
                "<span style='font-size: 10px; margin-right: 5px'>" . ($j + 1) . "</span>";
        }
        echo "<span> = " . $valueColumn[$i] . "</span>" . '<br><br>';
    }
    echo "<hr>";
}

function outputAsideMatrix($matrix) { // Вывод матрицы
    for ($i = 0; $i < 3; $i++) {
        echo "<span style='font-size: 16px; line-height: 20px'>x</span>" .
             "<span style='font-size: 10px; margin-right: 5px'>" . ($i + 1). " = </span>";
        for ($j = 0; $j < 3; $j++) {
            echo $matrix[$i][$j] . ($j !== 2 ? "<span style='font-size: 16px; line-height: 20px'>x</span>" .
                "<span style='font-size: 10px; margin-right: 5px'>" . ( $i <= $j ? ($j + 2) : ($j + 1)) . "</span>" : "");
        }
        echo '<br><br>';
    }
    echo "<hr>";
}

function add(Array $first, Array $second):Array { // Сложить две строки и вернуть результат
    $result = [];
    for ($i = 0; $i < count($first); $i++) {
        $result[] = round($first[$i] + $second[$i], 4);
    }
    return $result;
}

function subtract(Array $first, Array $second): Array { // Вычесть две строки и вернуть результат
    $result = [];
    for ($i = 0; $i < count($first); $i++) {
        $result[] = round($first[$i] - $second[$i], 4);
    }
    return $result;
}

function multiplyAndAdd(Array $first, Array $second, $multiplier): Array { // Умножить на число и сложить две строки и вернуть результат
    $result = [];
    for ($i = 0; $i < count($first); $i++) {
        $result[] = round($first[$i] * $multiplier + $second[$i], 4);
    }
    return $result;
}

function getAsideMatrix($initMatrix, $valueColumn, $xColumn):Array {
    $asideMatrix = [3][3];
    for($i = 0; $i < 3; $i++) {
        for($j = 0; $j < 3; $j++) {
            if($i < $j) {
                $asideMatrix[$i][$j - 1] = round((-$initMatrix[$i][$j] / $xColumn[$i]), 4);
            }
            else if($i > $j) {
                $asideMatrix[$i][$j] = round((-$initMatrix[$i][$j] / $xColumn[$i]), 4);
            }
        }
        $asideMatrix[$i][2] = round(($valueColumn[$i] / $xColumn[$i]), 4);
    }
    return $asideMatrix;
}

function checkIfNotEqual($row1, $row2) {
    if(intval($row1[0] * 1000) / 1000 === intval($row2[0] * 1000) /1000 &&
       intval($row1[1]* 1000) / 1000 === intval($row2[1]* 1000) / 1000 &&
       intval($row1[2]* 1000) / 1000 === intval($row2[2]* 1000) / 1000) {
        return false;
    }
    return true;
}

function getNewMatrix($matrix, $xColumn) {
    $newMatrix = [[0, 0, 0], [0, 0, 0] , [0, 0, 0]];
    for($i = 0; $i < 3; $i++) {
        for($j = 0; $j < 3; $j++) {
            if($j === 2) {
                $newMatrix[$i][$j] += $matrix[$i][$j];
            } else {
                $newMatrix[$i][$j] += ($matrix[$i][$j] * ($i <= $j ? $xColumn[$j + 1] : $xColumn[$j]));
            }
        }
    }
    return $newMatrix;
}

function getNewXColumn($tempMatrix) {
    $newColumn = [0, 0, 0];
    for($i = 0; $i < 3; $i++) {
        for($j = 0; $j < 3; $j++) {
            $newColumn[$i] += $tempMatrix[$i][$j];
        }
        echo 'X' . ($i + 1) . ' = ' .$newColumn[$i] . ' ';
    }
    return $newColumn;
}