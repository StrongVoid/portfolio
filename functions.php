<?php

//////////////////////////////////////////////////////////////////////////////////////
////////////////// ФУНКЦИЯ ОТПРАВКИ/ПЕРЕЗАПИСИ COOKIE КЛИЕНТУ ////////////////////////
//////////////////////////////////////////////////////////////////////////////////////

function editToken() {

  if ($_POST['inn']) { # Проверяем наличие значение в глобально массиве $_POST у ключа 'inn'   TRUE/FALSE

  $dataHistory = json_decode($_COOKIE['history'], true); # Записываем в переменну значение уже имеющейся COOKIE в json и переводим в PHP_array

  $countCookie = count($dataHistory) + 1; # Счётчик индекса, куда будет записана новая запись
  echo("Количество элементов в массиве: " . $countCookie . "<br>"); # Вывод количества ключей в массиве $dataHistory
  $dataHistory[$countCookie] = $_POST['inn']; # Передаём последнее введенное значение в конец массива


  $dataHistory = json_encode($dataHistory); # Перезаписываем $dataHistory (PHP_array) в json, для отправки в куки
  setcookie('history', $dataHistory); # Перезаписываем COOKIE с новым json массивом


  $dataHistory = json_decode($dataHistory, true); # Последнюю актуальную версию массива снова представляем в json > PHP_array
echo ("<h4>История запросов: </h4>"); # Выводим строку в интерфейс
  return($dataHistory); # Возвращаем из функции массив $dataHistory (PHP_array)
}}

//////////////////////////////////////////////////////////////////////////////////////
////////////////// ФУНКЦИЯ ОТПРАВКИ/ПЕРЕЗАПИСИ COOKIE КЛИЕНТА ////////////////////////
//////////////////////////////////////////////////////////////////////////////////////

function getHistory($dataHistory) {
# Берём полученный $dataHistory (PHP_array) и перебираем массив функцией for ()
  for ($i = 1; $i <= count($dataHistory); $i++) {
      echo ("$i. " . $dataHistory[$i] . "<br>"); # Отображаем введённые значение друг под другом. (Для удобного чтения на странице)
  }

}

//////////////////////////////////////////////////////////////////////////////////////
///////////////////// ФУНКЦИЯ ОТПРАВКИ ТЕЛА ЧЕКА НА ФИСКАЛИЗАЦИЮ /////////////////////
//////////////////////////////////////////////////////////////////////////////////////
function sendCheck($checkBody) {
  // echo($token);
  // echo("Подпись:  " . $nonce . "<br>");
  // var_dump($checkBody);
  $secret = "h8GiQoYeBlNncTyfX9St7J5wR6bm0xCV";                     # Задали ключик для интеграции от аккаунта с логином test
  $params_string = json_encode($checkBody, JSON_UNESCAPED_UNICODE); # Превратили ассоциативный массив $checkBody в JSON-массив с функцией удаления пробелов
   // var_dump($params_string);

  $reqSign = MD5($params_string . $secret);                         # Формируем подпись из имеющихся данных и представляем её в виде MD5 хеша
  // echo ("<br>Подпись: " . $reqSign);



  $url = 'https://check.business.ru/open-api/v1/Command';           # URL-адрес, куда улетит сформированный запрос

    $headers = array( # Формируем массив заголовков
        'Content-type: application/json', # Передаём Content-type
        'Accept: application/json',       # Передаём Accept
        'sign: ' . $reqSign,              # Передаём сформированную MD5-запись
      );

      $ch = curl_init($url);                                  # Запускаем отправку HTTP-запроса на $url
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);         # Представляем ответ в строке
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);         # Передаёт HTTP-заголовки
      curl_setopt($ch, CURLOPT_POST, true);                   # Передаём, что тип запроса POST
      curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);   # Передаём data-body запроса > наш массив чека
      $response = curl_exec($ch);                             # В переменную $response получаем записываем массив, который является ответом от сервиса
      $response_new = json_decode($response, true);           # Декодируем ответ с JSON на PHP_array
      return $response_new;                                   # Результат функции отдаём клиенту в интерфейс, для дальнейшего отображения
      curl_close($ch);                                        # Прекращаем инициализацию отправки HTTP-запроса
}


//////////////////////////////////////////////////////////////////////////////////////
///////////////////// ФУНКЦИЯ ОТПРАВКИ ЗАПРОСА НА ПОЛУЧЕНИЕ ТОКЕНА ///////////////////
//////////////////////////////////////////////////////////////////////////////////////
function getToken() {


  // $app_id=$_POST['app_id'];
  $app_id = "3b00b141-1149-4dda-abe9-1296dbe5aaeb";
  // $secret_key=$_POST['secret_key'];
  $secret_key = "h8GiQoYeBlNncTyfX9St7J5wR6bm0xCV";
  $nonce=md5(microtime(true));

  if ($_POST) {
    $params_string = json_encode(array(
        "app_id" => $app_id,
        "nonce" => $nonce
        ));

    $reqSign = MD5($params_string . $secret_key);

    $url = 'https://check.business.ru/open-api/v1/Token' . '?app_id=' . $app_id . '&nonce=' . $nonce;

    $headers = array(
    		'Content-type: application/json',
    		'Content-length: 0',
        'sign: ' . $reqSign,
    	);


    {
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      $response = curl_exec($ch);
      $response_new = json_decode($response, true);
      // echo "<h4>Куда отправляется запрос: </h4>" . $url . "<br>";
      echo($POST['send']);
      // echo "<h3><strong>Тело ответа: <br>";
      // echo isset($response_new['result']) ? "result: " . $response_new['result'] . "<br>" : NULL ;
      // echo isset($response_new['message']) ? "message: " . $response_new['message'] . "<br>" : NULL ;
      // echo isset($response_new['expires']) ? "expires: " . $response_new['expires'] . "<br>" : NULL ;
      // echo isset($response_new['token']) ? "token: " . $response_new['token'] . "<br>" : NULL ;
      echo "</h3>";
      // var_dump($response_new);
      return $response_new;
      curl_close($ch);

    }
  }

}

//////////////////////////////////////////////////////////////////////////////////////
///////////////////// ФУНКЦИЯ ПОЛУЧЕНИЯ ДАННЫХ О КОМПАНИИ ПО ИНН /////////////////////
//////////////////////////////////////////////////////////////////////////////////////
function getInfoByInn () {



  /////// ПРИСВАИВАЕМ ИМЕНА ДАННЫМ ИЗ ФОРМЫ ////
  $token=$_POST['token'];
  $inn=$_POST['inn'];
  // $count=$_POST['count']; # Закомментил count



 $turn = array();

  /////// ФОРМИРОВАНИЕ DATABODY ЗАПРОСА ////////
  if ($_POST) {
    $params_string = json_encode(array(
        "query" => $inn,
      ));
  };


    $url = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/party'; # В отдельную переменную записываем URL-адрес, куда будем отправлять HTTP-request

    $headers = array(												# Формируем заголовки
    		'Content-type: application/json',		# Content-type
    		'Accept: application/json',					# Accept
        'Authorization: Token ' . $token,   # Authorization
    	);																		#
  //

  if(isset($_POST['send'])) {
    echo "<h4>Куда отправляется запрос: </h4>" . $url . "<br>"; # Выводим адреc, куда уйдёт запрос, в интерфейс

      {
        $ch = curl_init($url);                                # Запускаем отправку HTTP-запроса на $url
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);       # Представляем ответ в строке
        curl_setopt($ch, CURLOPT_POST, true);                 # Передаём, что тип запроса POST
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);       # Передаёт HTTP-заголовки
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string); # Передаём data-body запроса > массив параметров
        $response = curl_exec($ch);                           # В переменную $response получаем записываем массив, который является ответом от сервиса
        $response_new = json_decode($response, true);         # Декодируем ответ с JSON на PHP_array


        echo "<h3>Полученный ответ: <br><br>";
        echo "<strong>Название компании: ";
        $nameCompany = print_r($response_new[suggestions][0][value]);    # Обращаемся к элементу массива, где содержится Наименование Компании

        echo "<br>КПП компании: ";
        $kppCompany = print_r($response_new[suggestions][0][data][kpp]); # Обращаемся к элементу массива, где содержится КПП Компании
        echo "</strong></h3>";

        curl_close($ch);                                      # Прекращаем инициализацию отправки HTTP-запроса

    }

  }

}



?>
