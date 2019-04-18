<?php
$beginning = 0;
$ending = 0.3;
$h = 0.1;
$variables = [
    'y' => 0.5,
    'z' => 1
];
$n = 3;
$k = 3;
$alpha = 2 + 0.5*$n;
$beta = 2 + 0.5*$k;
$x = $beginning;
$i = 1;
echo 'Отрезок: [' . $beginning . ', ' . $ending . ']. Шаг h: ' . $h .  '. N = ' . abs($ending - $beginning) / $h . '.<br><br>';

while ($x <= $ending) {
    $x += $h;
    echo $i . '-ая итерация:<br>x = ' . $x . '<br>';
    $deltas = getDelta($x, $variables['y'], $variables['z'], $h, $alpha, $beta);
    echo 'y<sub>' . ($i - 1) . '</sub> = ' . formatFloat($variables['y']) . ', z<sub>' . ($i - 1) . '</sub> = ' . formatFloat($variables['z']) . '<br>';
    $variables['y'] += $deltas['y'];
    $variables['z'] += $deltas['z'];
    echo '&Delta;y<sub>' . ($i - 1) . '</sub> = ' . formatFloat($deltas['y']) . ', &Delta;z<sub>' . ($i - 1) . '</sub> = ' . formatFloat($deltas['z']) . '<br>';
    echo 'y<sub>' . $i . '</sub> = ' . formatFloat($variables['y']) . ', z<sub>' . $i . '</sub> = ' . formatFloat($variables['z']) . '<br><br>';
    $i++;
}
echo 'Конец промежутка.';

function getDelta ($x, $y, $z, $h, $alpha, $beta) {
    $k1 = getEquationResult ($x, $y, $z, $h, $alpha, $beta);
    $k2 = getEquationResult ($x + $h/2, $y + $k1['y']/2, $z + $k1['z']/2, $h, $alpha, $beta);
    $k3 = getEquationResult ($x + $h/2, $y + $k2['y']/2, $z + $k2['z']/2, $h, $alpha, $beta);
    $k4 = getEquationResult ($x + $h, $y + $k3['y'], $z + $k3['z'], $h, $alpha, $beta);

    return [
        'y' => calculateDelta($k1, $k2, $k3, $k4, 'y'),
        'z' => calculateDelta($k1, $k2, $k3, $k4, 'z')
    ];
}

function calculateDelta ($k1, $k2, $k3, $k4, $var) {
    return 1/6 * ($k1[$var] + 2 * $k2[$var] + 2 *  $k3[$var] + $k4[$var]);
}

function getEquationResult ($x, $y, $z, $h, $alpha, $beta) {
    return [
        'y' => $h * (pow(exp(1), -(pow($y,2) + pow($z, 2))) + $alpha * $x),
        'z' => $h * ($beta * pow($y, 2) + $z)
    ];
}

function formatFloat ($number) {
    return number_format($number, 10, '.', '');
}