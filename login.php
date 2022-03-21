<?php
require_once 'inc/header.php';  # Рендер шапки интерфейса

if (!empty($_POST)) {
    require __DIR__ . '/auth.php';
    $login = $_POST['login'];
    $password = $_POST['password'];

    if (checkAuth($login, $password)) { # Проверка введёных данных в базе на наличие совпадение 
        setcookie('login', $login, 0, '/');
        setcookie('password', $password, 0, '/');
        header('Location: /index.php'); # Положительный ответ, выдаём куки и переводим на первую страницу
    } else {
        $error = 'Ошибка авторизации'; # отрицательный ответ, информаируем об этом в интерфейс клиента
    }
}
?>

<html>
<head>
    <title>Форма авторизации</title>
</head>
<body>
<?php if (isset($error)): ?>
<div align='center' style="color: red;">
    <?= $error ?>
</div>

<?php endif; # выводим ошибку авторизации?>

<form action="/login.php" method="post" align='center' >
    <label for="login">Логин: </label><input type="text" name="login" id="login">
    <br>
    <label for="password">Пароль: </label><input type="password" name="password" id="password">
    <br><br>
    <input type="submit" value="Войти">
</form>
</body>
</html>

<?php require_once 'inc/footer.php'  #РЕНДЕР ПОДВАЛА ИНТЕРФЕЙСА ?>
