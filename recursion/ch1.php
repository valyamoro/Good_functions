<?php
#1 Создание категорий и подкатегорий.
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

$smartPhones = createCategory(7, 'Смартфоны');
addChildCategory($child1, $smartPhones);
addChildCategory($child1, createCategory(4, 'Ноутбуки'));

printCategories($child1);

#2 Подсчет общей стоимости заказов и подзаказов.
function calculateTotal($order) {
    $total = 0;
    foreach ($order['items'] as $item) {
        if (is_array($item) && isset($item['items'])) {
            $total += calculateTotal($item); // Рекурсивный вызов для подзаказов
        } elseif (isset($item['price']) && isset($item['quantity'])) {
            $total += $item['price'] * $item['quantity'];
        }
    }
    return $total;
}

// Пример использования:
$order = [
    'items' => [
        ['productName' => 'Товар 1', 'quantity' => 2, 'price' => 10],
        [
            'items' => [
                ['productName' => 'Товар 2', 'quantity' => 1, 'price' => 20],
                ['productName' => 'Товар 3', 'quantity' => 3, 'price' => 15],
            ]
        ],
    ]
];

$totalCost = calculateTotal($order);
echo "Общая стоимость заказа: $" . $totalCost;

#3