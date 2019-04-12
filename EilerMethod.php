<?php
$accuracy = 0.000001;
$beginning = 2;
$ending = 2.5;
$h = 0.05;
$halfH = $h/2;
$initY = 1;
$initX = $beginning;
$nextY = 0;
$y = $initY + $h*getEquationResult($beginning, $initY);
$x1 = $beginning + $halfH;
$x2 = $x1 + $halfH;
$y1 = $y + $halfH*getEquationResult($beginning, $initY);
$y2 = $y1 + $halfH*getEquationResult($x1, $y1);

while (abs($y - $y2) >= $accuracy) {
    $result = takeOneIteration($initX, $initY, $h);
    $y = $result['y'];
    $y2 = $result['y2'];
    $h = $h/2;
}

printResult($h, $h/2, $y, $y2);
while($initX < $ending) {
    $halfH = $h/2;
    $initY = $initY + $h*getEquationResult($initX, $initY);
    do {
        $x1 = $initX + $halfH;
        $x2 = $x1 + $halfH;
        $y1 = $y + $halfH*getEquationResult($initX, $initY);
        $y2 = $y1 + $halfH*getEquationResult($x1, $y1);
    } while(abs($y - $y2) >= $accuracy);
    $initX = $initX + $h;
}
echo 'initY' . $initY . 'initX' . $initX;

function getEquationResult($x, $y) {
    return (2*$x*pow($y, 3))/(1 - pow($x, 2)*pow($y, 2));
}
function takeOneIteration ($initX, $initY, $h) {
    $halfH = $h/2;
    $y = $initY + $h*getEquationResult($initX, $initY);
    $x1 = $initX + $halfH;
    $y1 = $y + $halfH*getEquationResult($initX, $initY);
    $y2 = $y1 + $halfH*getEquationResult($x1, $y1);
    return ['y' => $y, 'y2' => $y2];
}
function formatFloat ($number) {
    return number_format($number, 8, '.', '');
}
function printResult($h, $halfH, $y, $y2) {
    echo 'Решение при шаге h = ' . formatFloat($h) . ' y = ' . formatFloat($y) . '<br>';
    echo 'Решение при шаге h/2 = ' . formatFloat($halfH) . ' y2 = ' . formatFloat($y2) . '<br>';
}
