<?php

/* Примечания:
 * 1. Не применяю к функции unset глобальную область видимости, т.к вызывает конфликт пространства имен.
 * 2.
 */
# 1
/** Функция для изменения ключей в простом массиве.
 * @param array $array
 * @param mixed $oldKey
 * @param mixed $newKey
 * @return void
 */
function changeArrayKeys(array &$array, mixed $oldKey, mixed $newKey): void
{
    // Проверяем существует ли старый ключ в массиве.
    if (\array_key_exists($oldKey, $array)) {
        // Присваиваем значение из старого элемента массива в новый по ключу.
        $array[$newKey] = $array[$oldKey];
        // Удаляем старый элемент массива вместе с ключом.
        unset($array[$oldKey]);
    }
}

#2
/**
 * Рекурсивная функция для подсчета суммы в многомерном и простом массиве.
 * @param array $array
 * @return int
 */
// Удалена, т.к ссылка в этой функции не нужна. - #1

// Пример вычисляемого массива:
$nestedArray = [3, 2, [[[[[[[[[[[[[[[[[[[[[[[[[[[6, 3]]]]]]]]]]]]]]]]]]]]]]]]]]]];

#3
/**
 * Функция для смены значений у чисел без третьей переменной.
 * @param int $a
 * @param int $b
 * @return void
 */
function swapIntValues(int &$a, int &$b): void
{
    // Присваиваем переменной $a сумму $a и $b
    $a = $a + $b;
    // Присваиваем переменной $b разность $a и $b
    $b = $a - $b;
    // Присваиваем переменной $a разность $a и $b
    $a = $a - $b;
}

#4.1.1

/**
 * Функция удаляющая элемент в простом массиве через ключ, с помощью цикла.
 * @param array $array
 * @param mixed $value
 * @return void
 */
function removeElementByValue(array &$array, mixed $value): void
{
    // Перебираем нужный массив.
    foreach ($array as $key => $element) {
        // Если введенное значение и существующий элемент в массива совпали - true:
        if ($element === $value) {
            // Удаляем найденный элемент массива через ключ.
            unset($array[$key]);
        }
    }
}

#4.1.2
/**
 * Функция удаляющая элемент в простом массиве через ключ, с помощью array_search.
 * @param array $array
 * @param mixed $element
 * @return void
 */
function removeElementByElement(array &$array, mixed $element): void
{
    // Проверяем существует ли переданное ЗНАЧЕНИЕ ЭЛЕМЕНТА в массиве, если да, то получаем ключ элемента.
    if (($key = \array_search($element, $array)) !== false) {
        // Удаляем найденный элемент через ключ.
        unset($array[$key]);
    }
}

#4.2
/**
 * Функция удаляющая элемент в простом массиве через ключ, с помощью array_key_exists.
 * @param array $array
 * @param mixed $key
 * @return void
 */
function removeElementsByKey(array &$array, mixed $key): void
{
    // Проверяем существует ли переданный КЛЮЧ в массиве, если да, то получаем ключ элемента.
    if (\array_key_exists($key, $array)) {
        // Удаляем найденный элемент через ключ.
        unset($array[$key]);
    }
}
/*
 * ВАЖНО
 * Различие последних двух функций заключается в том что, в функции поиска ключа передаются разные сущности.
 * Но по сути делают они одно и то же.
 */

#5
/**
 * Функция для изменения значений элементов в простом и многомерном массиве.
 * @param array $array
 * @param mixed $valueToChange
 * @param mixed $newValue
 * @return void
 */
function modifyMultiDimensionalArray(array &$array, mixed $valueToChange, mixed $newValue): void
{
    // Перебираем массив и присваиваем элементу массива ссылку для изменения значений внутри цикла.
    foreach ($array as &$element) {
        // Проверяем является ли текущий элемент массивом.
        if (\is_array($element)) {
            // Если да, то применяем рекурсию пока элемент перестанет быть массивом.
            modifyMultiDimensionalArray($element, $valueToChange, $newValue);

        // Если введенный элемент и элемент в массиве совпали, то:
        } elseif ($element === $valueToChange) {
            // Если элемент не является массивом, то элементу присваивается новое значение.
            $element = $newValue;
        }
    }
}

#6
/**
 * Рекурсивная функция для изменения названия ключей в простом и многомерном массиве.
 * @param array $array
 * @param mixed $oldKey
 * @param mixed $newKey
 * @return void
 */
function changeMultiDimensionalKey(array &$array, mixed $oldKey, mixed $newKey): void
{
    // Проверяем существует ли заменяемый ключ в массиве.
    if (array_key_exists($oldKey, $array)) {
        // Присваиваем старое значение новому элементу.
        $array[$newKey] = $array[$oldKey];
        // Удаляем старый элемент.
        unset($array[$oldKey]);
    }

    // Перебираем массив и присваиваем ссылку элементу массива.
    foreach ($array as &$value) {
        // Проверяем является ли элемент массивом.
        if (is_array($value)) {
            // Если элемент является массивом, то продолжаем перебирать массив рекурсивно.
            changeMultiDimensionalKey($value, $oldKey, $newKey);
        }
    }
}