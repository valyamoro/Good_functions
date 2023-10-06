<?php

#1
$numbers = [3, 4, 5, 6, 7, 8,10];

/**
 * Фильтрация чисел по четности.
 */
$filterNumbers = array_filter($numbers, function($number) {
    return $number % 2 == 0;
});

#2
/**
 * Сортировка по убыванию/возрастанию
 */
usort($students, function($a, $b) {
    return $b['score'] - $a['score'];
});

#3
/**
 * Преобразование первого символа строки каждого элемента массива в верхний регистр.
 */
$capitalizedFruits = array_map(function($fruit) {
    return ucfirst($fruit);
}, $fruits);

#4
/**
 * Функция для инкриминирования числового значения.
 */
function createCounter()
{
    $count = 0;

    return function() use (&$count) {
        return ++$count;
    };
}

#5
/**
 * Каррирование функции. Для вызова функции с частичным набором аргументов.
 * @param $fn
 * @return Closure
 */
function curry($fn)
{
    return function($x) use ($fn) {
        return function($y) use ($fn, $x) {
            return $fn($x, $y);
        };
    };
}

$add = function($a, $b) {
    return $a + $b;
};

#6
/**
 * @param array $allowedRoles
 * @return Closure
 */
function createAuthMiddleWare(array $allowedRoles)
{
    return function($userRole) use ($allowedRoles) {
        return in_array($userRole, $allowedRoles);
    };
}

#7
function createErrorHandler($logFile, $adminEmail) {
    return function($errorMessage) use ($logFile, $adminEmail) {
        file_put_contents($logFile, $errorMessage . PHP_EOL, FILE_APPEND);
        mail($adminEmail, 'Ошибка в приложении', $errorMessage);
    };
}

#8
function createCount() {
    $count = 0;

    return [
        'increment' => function() use (&$count) {
            $count++;
        },
        'getCount' => function() use (&$count) {
            return $count;
        }
    ];
}

#9
function factorial($n) {
    if ($n <= 1) {
        return 1;
    }
    return $n * factorial($n - 1);
}

// Без мемоизации:
echo factorial(20); // Время выполнения: доли секунды

// С мемоизацией:
function memoize($fn) {
    $cache = [];
    return function($n) use ($fn, &$cache) {
        if (!isset($cache[$n])) {
            $cache[$n] = $fn($n);
        }
        return $cache[$n];
    };
}

$factorial = memoize(function($n) {
    if ($n <= 1) {
        return 1;
    }
    return $n * $factorial($n - 1);
});

#10
function createHtmlBuilder() {
    $html = '';

    return [
        'openTag' => function($tagName, $attributes = []) use (&$html) {
            $attrString = '';
            foreach ($attributes as $attr => $value) {
                $attrString .= " $attr=\"$value\"";
            }
            $html .= "<$tagName$attrString>";
        },
        'closeTag' => function($tagName) use (&$html) {
            $html .= "</$tagName>";
        },
        'getContent' => function() use (&$html) {
            return $html;
        },
    ];
}

$htmlBuilder = createHtmlBuilder();
$htmlBuilder['openTag']('div', ['class' => 'container']);
$htmlBuilder['openTag']('p');
$htmlBuilder['closeTag']('p');
$htmlBuilder['closeTag']('div');
echo $htmlBuilder['getContent'](); // Выведет <div class="container"><p></p></div>

#11
// Массив товаров
$products = [
    ['id' => 1, 'name' => 'Товар 1', 'price' => 10.99, 'stock' => 50],
    ['id' => 2, 'name' => 'Товар 2', 'price' => 5.99, 'stock' => 100],
    ['id' => 3, 'name' => 'Товар 3', 'price' => 15.99, 'stock' => 25],
];

// Функция для отображения списка товаров
$displayProducts = function($products) {
    foreach ($products as $product) {
        echo "ID: {$product['id']}, Название: {$product['name']}, Цена: {$product['price']}, В наличии: {$product['stock']} шт.\n";
    }
};

// Функция для фильтрации товаров по наличию
$filterByStock = function($products, $minStock) {
    return array_filter($products, function($product) use ($minStock) {
        return $product['stock'] >= $minStock;
    });
};

// Функция для сортировки товаров по цене
$sortByPrice = function($products) {
    usort($products, function($a, $b) {
        return $a['price'] <=> $b['price'];
    });
    return $products;
};

#12
// Создание приватных переменных.
function createPrivateVariable($initialValue) {
    $privateVar = $initialValue;

    return (object) [
        'get' => function () use (&$privateVar) {
            return $privateVar;
        },
        'set' => function ($value) use (&$privateVar) {
            $privateVar = $value;
        },
    ];
}

$privateVar = createPrivateVariable("Начальное значение");
$privateVar->set("Новое значение");
echo $privateVar->get(); // Вывод: Новое значение
