<?php
#1
/*
 * Обработка ошибок.
 */
$errorCode = 404;
switch ($errorCode) {
    case 404:
        header("HTTP/1.0 404 Not Found");
        echo "Страница не найдена";
        break;
    case 500:
        header("HTTP/1.0 500 Internal Server Error");
        echo "Внутренняя ошибка сервера";
        break;
    // ...
}