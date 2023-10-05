<?php
#1
function quicksort(&$array)
{
    if (count($array) <= 1) {
        return $array;
    }
    $left = $right = [];

    reset($array);

    $pivot_key = key($array);
    $pivot = array_shift($array);

    foreach ($array as &$value) {
        if ($value < $pivot) {
            $left[] = $value;
        } else {
            $right[] = $value;
        }
    }
    return array_merge(quicksort($left,), [$pivot_key => $pivot], quicksort($right));
}