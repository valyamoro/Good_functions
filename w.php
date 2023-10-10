<?php

function createCategory($id, $name) {
    return [
        'id' => $id,
        'name' => $name,
        'children' => [],
    ];
}

function addChildCategory(&$parent, $child) {
    $parent['children'][] = $child;
}

function printCategory(&$parent, $child) {
    $parent['children'][] = $child;
}

function printCategories($category, $level = 0) {
    echo str_repeat('-', $level) . $category['name'] . '<br>';
    foreach($category['children'] as $child) {
        printCategories($child, $level + 1);
    }
}

$rootCategory = createCategory(0, 'Каталог товаров');
$child1 = createCategory(1, 'Электроника');
$child2 = createCategory(2, 'Одежда');

addChildCategory($rootCategory, $child1);
addChildCategory($rootCategory, $child2);
$phones = 'Смартфоны';
addChildCategory($child1, createCategory(3, $phones));
addChildCategory($child1, createCategory(4, 'Ноутбуки'));

printCategories($rootCategory);
