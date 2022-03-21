<?php
function checkAuth($login, $password) # Проверка на авторизованного пользователя
{
    $users = require __DIR__ . '/users.php';

    foreach ($users as $user) { # Проходим по массиву users и ищем совпадения
        if ($user['login'] === $login
            && $user['password'] === $password
        ) {
            return true; # Положительный ответ говорит о том, что "Совпадение Лог/Пас найден"
        }
    }

    return false; # Отрицательный ответ говорит о том, что "Совпадение Лог/Пас не найдено"
}

function getUserLogin() # Получение логина из $_COOKIE
{
    $loginFromCookie = $_COOKIE['login'];
    $passwordFromCookie = $_COOKIE['password'];

    if (checkAuth($loginFromCookie, $passwordFromCookie)) {
        return $loginFromCookie; # Положительный ответ > Возвращаем данные в интерфейс
    }

    return null; # Отрицательный ответ > Возвращаем null
}
?>
