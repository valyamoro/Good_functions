<?php
#1
/* Итерация по символам в строке.
 * Лучше заранее создать переменную с кол-вом символов в строке.
 * Иначе при каждой итерации цикл будет вычислять это значение.
 */
$str = 'Hello';
$strCount = strlen($str);
for ($i = 0; $i < $strCount; $i++) {
    echo $str[$i] . " ";
}

#2
/*
 * Генерация английского алфавита.
 */
$alphabet = [];
for ($letter = 'A'; $letter <= 'Z'; $letter++) {
    $alphabet[] = $letter;
}
print_r($alphabet);