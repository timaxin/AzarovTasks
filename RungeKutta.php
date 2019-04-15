<?php
$beginning = 0;
$ending = 0.3;
$h = 0.1;
$n = abs($ending - $beginning) / $h;
$variables = [
    'y' => 0.5,
    'z' => 1
];

$x = $beginning + $h;

function getDelta ($x, $y, $z, $h) {
    $k1 = $h * getEquationResult ($x, $y, $z);
    $k2 = $h * getEquationResult ($x + $h/2, $y + $k1['y']/2, $z + $k1['z']/2);
    $k3 = $h * getEquationResult ($x + $h/2, $y + $k2['y']/2, $z + $k2['z']/2);
    $k4 = $h * getEquationResult ($x + $h/2, $y + $k3['y']/2, $z + $k3['z']/2);
}

function getEquationResult ($x, $y, $z) {
    return [
        'y' => pow(exp(1), -(pow($y,2) + pow($z, 2))) + 2 * $x,
        'z' => 2.5 * pow($y, 2) + $z
    ];
}