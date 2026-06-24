<?php
// function getDiagonalSum($arr)
// {
//     return $sum;
// }

function getDiagonalSum(array $matrix): int|float
{
    $n = count($matrix);

    $topLeftToBottomRight = 0;
    $bottomRightToTopLeft = 0;

    for ($i = 0; $i < $n; $i++) {
        // Diagonal: [0][0], [1][1], [2][2]
        $topLeftToBottomRight += $matrix[$i][$i];

        // Diagonal: [0][2], [1][1], [2][0]
        $bottomRightToTopLeft += $matrix[$i][$n - 1 - $i];
    }

    $sum = abs($topLeftToBottomRight - $bottomRightToTopLeft);

    return $sum;
}

// --- Test matrix ---
$array = [
    0 => [0 => 11, 1 => 2,  2 => 4],
    1 => [0 => 4,  1 => 5,  2 => 6],
    2 => [0 => 10, 1 => 8,  2 => -12],
];

$vysledok = getDiagonalSum($array);

echo "Výsledok: abs(hlavná - vedľajšia) = {$vysledok}" . PHP_EOL;
// Výsledok: abs(hlavná - vedľajšia) = 15
//1
$str1 = 'yabadabadoo';
$str2 = 'yaba';
if (false !== strpos($str1, $str2)) {
    echo "\"" . $str1 . "\" contains \"" . $str2 . "\"";
} else {
    echo "\"" . $str1 . "\" does not contain \"" . $str2 . "\"";
}
// strpos vracia false, alebo int - pozíciu na ktorej začína hľadaný reťazec. Preto bolo potrebné upraviť podmienku

//2
$referenceTable = [];
$referenceTable['val1'] = [1, 2];
$referenceTable['val2'] = [3]; // hodnota nebola pole
$referenceTable['val3'] = [4, 5];

$testArray = [];

$testArray = array_merge($testArray, $referenceTable['val1']);
var_dump($testArray);
$testArray = array_merge($testArray, $referenceTable['val2']);
var_dump($testArray);
$testArray = array_merge($testArray, $referenceTable['val3']);
var_dump($testArray);

//3
class Counter
{
    public function checkMaxMinSum(array $numbersToSum): array
    {
        $i = 0;
        $sums = [];
        $arraySum = array_sum($numbersToSum);

        foreach ($numbersToSum as $number) {
            $sums[] = $arraySum - $number;
            $i++;
        }

        return [max($sums), min($sums)];
    }
}

$numbers = [10, 20, 30, 40, 50];

$counter = new Counter();
$result = $counter->checkMaxMinSum($numbers);
print_r($result);

// neviem, či je to vypracované podľa predstavy. Samotná funkcia checkMaxMinSum je zavolaná len 1x. Tá obsahuje slučku, ktorá inkrementuje počítadlo.


//4
// toto som nemal najmenšej potuchy ako vyriešiť. S maticami som sa naposledy stretol v škole. A tak som sa opýtal Claude-a. Jeho riešenie:

function getDiagonalSum(array $matrix): int|float
{
    $n = count($matrix);

    $topLeftToBottomRight = 0;
    $bottomRightToTopLeft = 0;

    for ($i = 0; $i < $n; $i++) {
        // Diagonal: [0][0], [1][1], [2][2]
        $topLeftToBottomRight += $matrix[$i][$i];

        // Diagonal: [0][2], [1][1], [2][0]
        $bottomRightToTopLeft += $matrix[$i][$n - 1 - $i];
    }

    $sum = abs($topLeftToBottomRight - $bottomRightToTopLeft);

    return $sum;
}

// --- Test matrix ---
$array = [
    0 => [0 => 11, 1 => 2,  2 => 4],
    1 => [0 => 4,  1 => 5,  2 => 6],
    2 => [0 => 10, 1 => 8,  2 => -12],
];
// V zadaní boli podľa Claude-a aj nesprávne kľúče v jednotlivých poliach.

$result = getDiagonalSum($array);

echo "Výsledok: abs(hlavná - vedľajšia) = {$vysledok}" . PHP_EOL;


//5
function secondMax(array $arr): array
{
    $max = max($arr);
    $second = 0;
    $maxKey = $secondKey = null;

    foreach ($arr as $key => $value) {
        if ($value < $max && $value > $second) {
            $second = $value;
            $secondKey = $key;
        }
    }

    return [$secondKey, $second];
}

$cookies = [
    "chocolate" => "20",
    "vanilla" => "14",
    "strawberry" => "18",
    "raspberry" => "19",
    "bluebery" => "29"
];

print_r(secondMax($cookies));
