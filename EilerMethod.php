<?php
$accuracy = 0.0001;
$beginning = 2; // Начало промежутка
$ending = 2.5; // Конец промежутка
$h = 0.05; // Шаг h
$halfH = $h/2;
$initY = 1; // Значение y в начале промежутка
$initX = $beginning;

$y = $initY + $h*getEquationResult($beginning, $initY);
$x1 = $beginning + $halfH;
$y1 = $y + $halfH*getEquationResult($beginning, $initY);
$y2 = $y1 + $halfH*getEquationResult($x1, $y1);

while (abs($y - $y2) >= $accuracy) { // Находим первый y с заданной точностью
    $result = takeOneIteration($initX, $initY, $h);
    $y = $result['y'];
    $y2 = $result['y2'];
    $h = $h/2;
}
echo 'Первый y, совпавший с заданной точностью с y после двойного пересчёта:<br>y<sub>1</sub>: <br>';
printResult($h, $h/2, $y, $y2);
echo '<br>Здесь и далее: y - решение до двойного пересчёта, y<sub>2</sub> - решение после двойного пересчёта<br>';
$i = 0;
while($initX < $ending) {
    $halfH = $h/2;
    $y = $initY + $h*getEquationResult($initX, $initY);
    $x1 = $initX + $halfH;
    $y1 = $y + $halfH*getEquationResult($initX, $initY);
    $y2 = $y1 + $halfH*getEquationResult($x1, $y1);
    if (abs($y - $y2) >= $accuracy) {
        echo '<br>Итерация ' . $i . ':<br>y<sub>2</sub> = ' . formatFloat($y2) . ', y = ' . formatFloat($y);
        echo '<br> |y<sub>2</sub> - y| > ' . $accuracy . '<br>Следовательно, необходимо уменшить шаг h:<br>Предыдущий h: ' .
            formatFloat($h) . '. Новый шаг h=h/2: ' . formatFloat($h/2) . '<br>';
        $h /= 2;
    } else {
        $initY = $y;
        $initX = $initX + $h;
    }
    if ($i % 3000 === 0) {
        echo '<br>Итерация ' . $i . ':<br>Решение: y = ' . formatFloat($y) . ', y2 = ' . formatFloat($y2) .
            '. Шаги: h = ' . formatFloat($h) . ', h/2 = ' . formatFloat($h/2) . '<br>';
    }
    $i++;
}
echo '<br>Конец промежутка<br>y = ' . formatFloat($y) . '; y<sub>2</sub> = ' . formatFloat($y2) . '; x = ' . formatFloat($initX) . '<br>';
echo 'Всего ' . $i . ' итераций';

function getEquationResult($x, $y) {
    return (2*$x*pow($y, 3))/(1 - pow($x, 2)*pow($y, 2)); // Метод, рассчитывающий результат уравнения при заданных x и y
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
    return number_format($number, 9, '.', ''); // Метод для форматирования вывода (9 знаков после запятой)
}
function printResult($h, $halfH, $y, $y2) {
    echo '  Решение при шаге h = ' . formatFloat($h) . ' y = ' . formatFloat($y) . '<br>';
    echo '  Решение при шаге h/2 = ' . formatFloat($halfH) . ' y2 = ' . formatFloat($y2) . '<br>';
}