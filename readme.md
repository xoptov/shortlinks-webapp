Сервис для создания коротких ссылок
===
Развернуть сервис моджно как локально настроинным окружением, так и с использоватнием Docker.
Докер для проекта можно взять тут: https://github.com/xoptov/shortlinks-docker


Для заполнения БД начальными данными можно использовать фикстуры.


Описание API
===
Запрос на создание новой короткой ссылки  
---
Заголовке необходимо указать: X-Auth-Token: [токен]

Загловок запроса должен содержать: Content-Type: application/json  
Endpoint: POST /shortlink  

Тело запроса должно быть формата JSON:  
{"url": "http://..."}

Пример корректного ответа:  
{"id": X, "shortUrl": "..."}  
Где id - это идентификатор короткой ссылки, а shortUrl это сама короткая ссылка.

Запрос на получения статистики
---
Endpoint: GET /statistics?groupedBy[]= или GET /statistics?groupedBy=  

Параметр groupedBy обрабатывается как просто значение или как массив, если нужно 
передать несколько полей то параметр должен выглядеть следующим образом:
GET /statistics?groupedBy[]=user&groupedBy[]=date

В groupedBy поддерживаются только поля user и date.

Обработка коротких ссылок
---
Запросы обрабатываются только GET и как есть, ни каких дополнительных полей и 
заголовков передавать не требуется.
