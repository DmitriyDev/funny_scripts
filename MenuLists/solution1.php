<?php

define("MAX", 30);

$firstDishName = ['soup', 'borsch', 'cream-soup'];
$secondDishName = ['porridge', 'pilau'];
$thirdDishName = ['compote', 'tea', 'jelly'];

$firstDishPrice = [20, 24, 18];
$secondDishPrice = [8, 9];
$thirdDishPrice = [2, 3, 4];

function createDictionary($names, $prices): callable
{
    return function ($generator) use ($names, $prices) {
        $index = $generator->current();
        return ["name" => $names[$index], "price" => $prices[$index]];
    };
}

function createGenerator($arr): Generator
{
    $max = count($arr) - 1;
    $generator = function () use ($max) {
        yield from range(0, $max);
    };

    return $generator();
}

$fGen = createGenerator($firstDishName);
$sGen = createGenerator($secondDishName);
$tGen = createGenerator($thirdDishName);

$firstDict = createDictionary($firstDishName, $firstDishPrice);
$secondDict = createDictionary($secondDishName, $secondDishPrice);
$drinksDict = createDictionary($thirdDishName, $thirdDishPrice);

while (true) {
    list($first, $second, $third) = [$firstDict($fGen), $secondDict($sGen), $drinksDict($tGen)];

    $price = $first['price'] + $second['price'] + $third['price'];

    if ($price <= MAX) {
        echo sprintf("%s %s %s : %d\n", $first['name'], $second['name'], $third['name'], $price);
    }

    $fGen->next();

    if (!$fGen->valid()) {
        $fGen = createGenerator($firstDishName);
        $sGen->next();
    }

    if (!$sGen->valid()) {
        $sGen = createGenerator($secondDishName);
        $tGen->next();
    }

    if (!$tGen->valid()) {
        break;
    }
}