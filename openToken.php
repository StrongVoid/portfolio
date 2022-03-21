<?php require_once 'inc/header.php';    # Рендер шапки интерфейса
include 'functions.php';                # Подключение файла функций
require_once 'auth.php'; 		# Подключаем авторизацию
$login = getUserLogin();		# Выводим переменную $login из авторизации, для дальнейшей проверки
 ?>


 <div align='center'>
    <?php if ($login === null): #Проверяем наличие авторизации ?>
      <a href="/login.php"><h2><strong>Авторизуйтесь</strong></h2></a>
    <?php else: #Если авторизация найдена, продолжаем рендер страницы ?>
</div>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Токен</title>
</head>
<body>
<hr>
<div class="block-1" align="center">
  <!-- ///////////////////////////////////////////////////////////////////////////////////////////////// -->
  <!-- СОЗДАЁМ ПОЛЬЗОВАТЕЛЬСКУЮ ФОРМУ, ОТКУДА БУДЕМ, В ДАЛЬНЕЙШЕМ, ПРИНИМАТЬ ДАННЫЕ, КОТОРЫЕ ВВЁЛ КЛИЕНТ -->
  <!-- ///////////////////////////////////////////////////////////////////////////////////////////////// -->

  <h3>__Получение токена от OpenAPI__</h3><br>
    <h4>Введите данные ключей интеграции:</h4>
     <form method="post" action="openToken.php">
      <p><input type="text" name="app_id" value="3b00b141-1149-4dda-abe9-1296dbe5aaeb">  <= Введите app_id</input></p>
      <p><input type="text" name="secret_key" value="h8GiQoYeBlNncTyfX9St7J5wR6bm0xCV">  <= Введите secret_key</input></p>
      <p><button type="submit" name="send" value="True"> Отправить </button></p>
      <hr>
      </form>

   <?php endif; # До этого момента рендерим страницу для  авторизованного пользователя?>
<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////// ВЫВОД ПОЛУЧЕННОГО АССОЦИАТИВНОГО МАССИВА ИЗ ФОРМЫ В ИНТЕРФЕЙС ///////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($_POST['send'])) {
  echo "<p><h4>Введёные данные:</h4></p>";
  echo "<br>Полученное app_id: " . $_POST['app_id'];
  echo "<br>Полученный secret_key: " . $_POST['secret_key'];
  echo "<br>Полученный nonce: " . $uTime . "          <=  md5(microtime)";
  echo "<br>Полученный send: " . $_POST['send'];
  echo "<hr></div>";
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////// ВЫВОД ВСЕХ ЗНАЧЕНИЙ ГЛОБАЛЬНОГО МАССИВА $_POST ПЕРЕД ОТПРАВКОЙ ЗАПРОСА///////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($_POST['send'])) {
echo"<h3> Полученный массив данных для формирования запроса";
  echo "<pre>";
  print_r($_POST);
  echo "</pre></h3><div align='center'>";
}




$saveToken = getToken();          # Создаём переменную $saveToken, значение которой будет результат работы функции getToken()
$token = $saveToken['token'];     # Записываем в переменную $token значение из полученного массива $saveToken
$expires = $saveToken['expires']; # Записываем в переменную $expires значение из полученного массива $saveToken
$result = $saveToken['result'];   # Записываем в переменную $result значение из полученного массива $saveToken
$message = $saveToken['message']; # Записываем в переменную $message значение из полученного массива $saveToken


////////////////// ВЫВОДИМ ОТВЕТ В ИНТЕРФЕЙС КЛИЕНТА ///////////////////////
echo isset($saveToken) ? "<h3><strong>Тело ответа: <br>" : NULL ;  # Проверка на наличие null в $saveToken
echo isset($token) ? "result: " . $token . "<br>" : NULL ;      	 # Проверка на наличие null в $token
echo isset($expires) ? "message: " . $expires . "<br>" : NULL ;	   # Проверка на наличие null в $expires
echo isset($result) ? "expires: " . $result . "<br>" : NULL ;  	   # Проверка на наличие null в $result
echo isset($message) ? "token: " . $message . "<br>" : NULL ;  	   # Проверка на наличие null в $message
echo("</strong>");
?>

</div>
</div>
</body>
</html>

<?php require_once 'inc/footer.php' # РЕНДЕР ПОДВАЛА ИНТЕРФЕЙСА ?>
