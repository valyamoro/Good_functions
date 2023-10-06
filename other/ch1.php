<?php

#1
// Изменение значение и ключа.
$data = [$newKey => $data[$oldKey]] + array_diff_key($data, [$oldKey => $data[$oldKey]]);

#2
// Кэширование параметров у запросов.
function getCachedData($key) {
    if (isset($cache[$key])) {
        return $cache[$key];
    } else {
        $data = performDatabaseQuery($key);
        $cache[$key] = $data;
        return $data;
    }
}

#3
