<?php
# PHP >=8.0
#---- Init
define("MAX", 35);

$firstDishName = ['soup', 'borsch', 'cream-soup'];
$secondDishName = ['porridge', 'pilau'];
$thirdDishName = ['compote', 'tea', 'jelly'];
$finalDish = ["bread", "banana-break", "cake", "apple-pie"];

$firstDishPrice = [20, 24, 18];
$secondDishPrice = [8, 9];
$thirdDishPrice = [2, 3, 4];
$finalDishPrice = [2, 3, 4, 5];

$menu = createMap(
    [$firstDishName, $secondDishName, $thirdDishName, $finalDish],
    [$firstDishPrice, $secondDishPrice, $thirdDishPrice, $finalDishPrice]
);

#---- end init ---

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

function createMap($names, $prices): array
{
    return array_map(
        fn($names, $prices) => [
            'generator' => createGenerator($names),
            'dictionary' => createDictionary($names, $prices),
            'keys' => array_keys($names),
        ],
        $names,
        $prices
    );
}

#-- Process

while (true) {
    $dicts = array_map(fn($x) => $x['dictionary']($x['generator']), $menu);
    $price = array_sum(array_map(fn($x) => $x['price'], $dicts));

    if ($price <= MAX) {
        $names = array_map(fn($x) => $x['name'], $dicts);
        echo sprintf("%s: %d\n", implode(' ', $names), $price);
    }

    $final = false;
    while (true) {
        $current = (current($menu));
        $current['generator']->next();

        if ($current['generator']->valid()) {
            break;
        }
        $generator = $current['generator'];
        $menu[key($menu)]['generator'] = createGenerator($current['keys']);
        next($menu);

        if (current($menu) === false) {
            break 2;
        }
    }
    reset($menu);
}
