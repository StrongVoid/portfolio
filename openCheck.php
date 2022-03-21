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
	    <title>Отправка чека</title>
  </head>
<body>
<hr>
<div class="block-1" align="center">
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- СОЗДАЁМ ПОЛЬЗОВАТЕЛЬСКУЮ ФОРМУ, ОТКУДА БУДЕМ, В ДАЛЬНЕЙШЕМ, ПРИНИМАТЬ ДАННЫЕ, КОТОРЫЕ ВВЁЛ КЛИЕНТ -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////// -->

  <h3>__Форма для создания чека__</h3><br>
      <h4>Заполните необходимые позиции:</h4>
      <form method="post" action="openCheck.php">
       <p><input type="text" name="name" value="Гармонь и я">  <= Название товара</input></p>
       <p><input type="text" name="count" value="10">  <= Количество товара</input></p>
       <p><input type="text" name="price" value="10">  <= Стоимость 1 позиции</input></p>

       <p><select size="2" multiple name="type">
        <option selected value="printCheck">Приход</option>
        <option value="printPurchaseReturn">Возврат прихода</option></select></p>
       <p><button type="submit" name="send" value="True"> Отправить </button></p>

</form>
<hr>
<?php endif; # До этого момента рендерим страницу для  авторизованного пользователя?>

<?php
////////////// ФОРМАТИРОВАНИЕ ДАННЫХ ИЗ МАССИВА ГЛОБАЛЬНОЙ $_POST ДЛЯ БОЛЕЕ УДОБНОГО ВНЕДРЕНИЯ В ШАБЛОН ////////////////
    $app_id = $_POST['app_id'] = "3b00b141-1149-4dda-abe9-1296dbe5aaeb";
    $command = $_POST['command'] = "0";
    $nonce = $_POST['nonce'] = md5(microtime(true));
    $saveToken = getToken();
    $token = $_POST['token'] = $saveToken['token'];
    $c_num = $_POST['c_num'] = rand(100000,9999999);
    $author = $_POST['author'] = "Виталя";
    $smsEmail54FZ = $_POST['smsEmail54FZ'] = "vetaligrach@gmail.com";
    $payed_cashless = $_POST['payed_cashless'] = $_POST['price'] * $_POST['count'];
    $sum = $_POST['sum'] = $_POST['price'] * $_POST['count'];
    $item_type = $_POST['item_type'] = 1;
    $nds_value = $_POST['nds_value'] = 0;
    $payment_mode = $_POST['payment_mode'] = 4;
    $nds_not_apply = $_POST['nds_not_apply'] = True;
    $name = $_POST['name'];
    $count = $_POST['count'];
    $price = $_POST['price'];
    $type = $_POST['type'];
// var_dump(json_encode($_POST)); # Вывод глобальной $_POST в виде JSON  в интерфейс

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////ШАБЛОН МАССИВА ДАННЫХ ДЛЯ УСПЕШНОГО ЗАПРОСА НА ФОРМИРОВАНИЕ ЧЕКА ПРИХОДА И ЧЕКА ВОЗВРАТА//////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$checkBody = array(
  'app_id' => $app_id,
  'command' => array(
    'c_num' => $c_num,
    'author' => $author,
    'smsEmail54FZ' => $smsEmail54FZ,
    'payed_cashless' => $payed_cashless,
    'goods' => array(
      array(
        'sum' => $sum,
        'name' => $name,
        'count' => $count,
        'price' => $price,
        'item_type' => $item_type,
        'nds_value' => $nds_not_apply,
        'payment_mode' => $payment_mode,
        'nds_not_apply' => $nds_not_apply,
      ),),),
  'nonce' => $nonce,
  'token' => $token,
  'type' => $type
);

// var_dump(json_encode($checkBody));  # Вывод ассоциативного массива щаблона в виде JSON  в интерфейс
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////// ВЫВОД ПОЛУЧЕННЫХ В ФОРМЕ HTML ДАННЫХ ИЗ ГЛОБАЛЬНОЙ $_POST В ИНТЕРФЕЙС ///////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['send'])) {
echo "<p><h4>Введёные данные:</h4></p>";
echo "<br>Полученное название: " . "<strong>" . $_POST['name'] . "</strong>";
echo "<br>Полученное количество: " . "<strong>" . $_POST['count'] . "</strong>";
echo "<br>Полученная стоимость: " . "<strong>" . $_POST['price'] . "</strong>";
echo "<hr>";
}

?>
</div>

<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////// ОТЛАДКА МАССИВА ПЕРЕД ОТПРАВКОЙ НА ОБРАБОТКУ В  ФУНКЦИЮ sendCheck() /////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($_POST['send'])) {
echo"<h3> Полученный массив данных для формирования запроса";
  echo "<pre>";
  print_r($checkBody);
  echo "</pre>";
}

/////////////////// ПОЛУЧАЕМУ АССОЦИАТИВНЫЙ МАССИВ ДАННЫХ ОТ OpenAPI И ВЫВОДИМ РЕЗУЛЬТАТ В ИНТЕРФЕЙС ///////////////////////
$resultCheck = sendCheck($checkBody);                                                                                # Записываем ассоциативный массив, который получаем по итогу работы функции sendCheck
if(isset($resultCheck['command_id'])) {                                                                              # Проверка массива ответа от OpenAPI на наличие ключа 'command_id'
echo ("<br><h2 align='center'><strong>Полученный command_id: " . $resultCheck['command_id'] . "</strong></h2>");     # Выводим ответ на страницу
}
?>
</body>
</html>

<?php require_once 'inc/footer.php' # РЕНДЕР ПОДВАЛА ИНТЕРФЕЙСА ?>











































<?php require_once 'inc/footer.php' ?>
