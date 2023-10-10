<?php

#1
function createOrder($customerName, $customerEmail)
{
    $order = [
        'customer_name' => $customerName,
        'customer_email' => $customerEmail,
        'products' => [],
        'total_price' => 0,
    ];

    $addToOrder = function ($product, $price) use (&$order) {
        $order['products'][] = [
            'product' => $product,
            'price' => $price,
        ];
        $order['total_price'] += $price;
    };

    $checkOut = function () use (&$order) {
        return $order;
    };

    return [
        'addToOrder' => $addToOrder,
        'checkout' => $checkOut,
    ];
}

// Создаем заказ
$orderFunctions = createOrder('John Doe', 'johndoe@example.com');

// Добавляем продукты к заказу
$orderFunctions['addToOrder']('Product 1', 10);
$orderFunctions['addToOrder']('Product 2', 20);

// Оформляем заказ
$orderDetails = $orderFunctions['checkout'];

// Выводим информацию о заказе
print_r($orderDetails());

#2
function accessControl($roles) {
    return function ($resource) use ($roles) {
        return function ($action) use ($resource, $roles) {
            if (in_array($action, $roles)) {
                return "Access granted to $action on $resource.";
            } else {
                return "Access denied to $action on $resource.";
            }
        };
    };
}

$adminAccess = accessControl(["create", "read", "update", "delete"]);
$guestAccess = accessControl(["read"]);

$resource = "document";

$adminRead = $adminAccess($resource)("read"); // Access granted to read on document.
$guestUpdate = $guestAccess($resource)("update"); // Access denied to update on document.

echo $adminRead . "\n";
echo $guestUpdate . "\n";

#3
function orderAccessControl($userRoles) {
    return function ($orderId) use ($userRoles) {
        return function ($action) use ($orderId, $userRoles) {
            $order = getOrderById($orderId);
            if (!$order) {
                return "Order not found.";
            }

            if (in_array($action, ["view", "print"]) && in_array("customer", $userRoles)) {
                return "Access granted to $action order #$orderId for customer.";
            } elseif (in_array($action, ["view", "edit", "cancel"]) && in_array("staff", $userRoles)) {
                return "Access granted to $action order #$orderId for staff.";
            } else {
                return "Access denied to $action order #$orderId for user.";
            }
        };
    };
}

// Пример ролей пользователя
$customerRoles = ["customer"];
$staffRoles = ["staff"];

// Создаем каррированные функции для управления заказами
$customerOrderAccess = orderAccessControl($customerRoles);
$staffOrderAccess = orderAccessControl($staffRoles);

$orderId = 12345;

$customerViewOrder = $customerOrderAccess($orderId)("view");
$staffEditOrder = $staffOrderAccess($orderId)("edit");
$customerCancelOrder = $customerOrderAccess($orderId)("cancel");

#4
function orderStatusControl($userRoles) {
    return function ($orderId) use ($userRoles) {
        return function ($newStatus) use ($orderId, $userRoles) {
            $currentStatus = getCurrentStatus($orderId);

            if (!in_array($newStatus, ["processing", "shipped", "delivered"])) {
                return "Invalid status: $newStatus";
            }

            if ($currentStatus === "processing" && in_array($newStatus, ["shipped", "delivered"]) && in_array("staff", $userRoles)) {
                updateStatus($orderId, $newStatus);
                return "Order #$orderId status updated to $newStatus by staff.";
            } elseif ($currentStatus === "shipped" && $newStatus === "delivered" && in_array("customer", $userRoles)) {
                updateStatus($orderId, $newStatus);
                return "Order #$orderId marked as delivered by customer.";
            } else {
                return "Access denied to change status of order #$orderId to $newStatus.";
            }
        };
    };
}

// Пример ролей пользователя
$customerRoles = ["customer"];
$staffRoles = ["staff"];

// Создаем каррированные функции для управления статусами заказов
$customerStatusControl = orderStatusControl($customerRoles);
$staffStatusControl = orderStatusControl($staffRoles);

$orderId = 12345;

$customerChangeStatus = $customerStatusControl($orderId);
$staffChangeStatus = $staffStatusControl($orderId);

$customerResult = $customerChangeStatus("shipped");
$staffResult = $staffChangeStatus("shipped");

#5