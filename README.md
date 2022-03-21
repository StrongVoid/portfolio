# Портфолио
Данный проект был написан строго для ознакомления с моими навыками веб-разработки на стеке HTML/CSS/PHP, JS в данном проекте не применялся, но опыт был на htmlacademy.
В дальнейшем планируется провести апдейт знаний PHP и перейти на фреймворк на его базы - Laravel/Symfony (Пока не определился)

# Что есть в этом проекте
В данном проекте представлен функционал php:
> 1. Фронтенд, применяя технологию шаблонов на PHP, код всей страницы занимает две строки>
> 2. Интеграция с сервисом Dadata.
> 3. Корректное получение массива данных и отображение в интерфейс.
> 4. Система записи истории запросов к сервису Dadata.
> 5. Очистка кода путём написания функций в отдельной исполняемом файле functions.php.
> 6. Комментирование кода в моментах, где необходимы пояснения.
> 7. Интеграция с сервисом Онлайн-Чеки.
> 8. Получение токена по app_id/secret_key клиента, прямо из интерфейса.
> 9. Система формирования запроса на фискализацию в сервис онлайн чеки на аккаунт с логином "test", так же из интерфейса.
> 10. Применение технологии работы с глобальнмыи массивами в PHP.
> 11. Работа с GET/POST/COOKIE - запросами и массивами $_GET/$_POST/$_COOKIE. А так же с библиотекой cURL и заголовками запросов
> 12. При помощи COOKIE реализована система защиты контента от неавторизованных пользователей.
> 13. N-ое множество разных мелочей из особенности php, например, cookie на стороне клиента не может быть array, и т.д.

# Кратко по проекту
1. На странице login.php > происходит авторизация
2. На странице apiDadata > Получение информации о компании по ИНН + ведётся история отправленных запросов
3. На странице openToken > Получение токена в сервисе Онлайн-Чеки по app_id и secret_key
4. На странице openCheck > Отправка чека на фискализацию в сервис Онлайн-чеки по аккаунту test