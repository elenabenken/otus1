# otus_1
<h2>Интернет-магазин «Ретро»</h2>
<h3>История изменений</h3>
<table>
  <tr>
    <th> Дата</th><th> Описание</th><th>	Версия</th>
  </tr>
  <tr>
    <th>3.12.2019</th><th> 	Первая редакция черновика</th><th> 	1.0 draft 1</th>
  </tr>
 <table>
<h3>Общее описание Системы</h3>
   <p>Система реализует функционал интернет-магазина, торгующего предметами в стиле ретро.</p>
   <p>Приложение должно быть реализовано по модели трехуровневой архитектуры.</p>
   <p>
     <ol>
       <li>Клиент – браузер пользователя магазина или администратора.</li>
       <li>Сервер приложений – nginx с модулем php. Бизнес-логика приложения реализована на языке php.</li>
        <li>Сервер баз данных – mysql, база данных shop.</li>
   </ol>
   </p>
<h3>Операционная среда</h3>
   <p>Компоненты приложения развернуты в контейнерах docker на базе ОС Ubuntu 18.04.</p>
  <h3>Модель данных</h3>
  <p>В настоящей версии база данных состоит из двух таблиц, представленных на рис. 1.</p>

![Image alt](https://github.com/elenabenken/otus1/raw/master/Database.png)
  <div>Рис. 1. Модель данных Системы.</div>
  
  <h3>API</h3>
  В этой версии реализованы следующие методы:
  <table>
  <tr>
    <th colspan="5">Регистрация в системе и аутентификация пользователя</th>
  </tr>
  <tr> 
    <th>HTTP-метод</th> <th>Endpoint</th> <th>Входные параметры</th> <th>Функционал</th> <th>Возвращаемое значение</th> 
  </tr>
  <tr> 
    <td>POST</td>  <td>/users/register</td> <td>name, password, email</td> <td>Зарегистрироваться в системе</td> <td>Сообщение об успехе или ошибке</td>
  </tr>
  <tr> 
    <td>POST</td>  <td>/users/login</td> <td>name, password</td> <td>Войти в систему</td><td>Сообщение об успехе или ошибке</td>
  </tr>
  <tr> 
    <td>POST</td>  <td>/users/logout</td> <td>name</td> <td>Выйти из системы</td><td>Сообщение об успехе или ошибке</td>
  </tr>
  <tr>
    <th colspan="5">Операции CRUD с товарами в магазине</th>
  </tr>
    <tr> 
      <th>HTTP-метод</th> <th>Endpoint</th> <th>Входные параметры</th> <th>Функционал</th> <th>Возвращаемое значение</th>
  </tr>
  <tr> 
    <td>POST</td>  <td>/goods/list</td> <td> - </td> <td>Просмотреть список товаров</td> <td>Список товаров и всех их атрибутов в json-формате</td></tr>
  <tr> 
    <td>POST</td>  <td>/goods/insert</td> <td>name,price, category</td> <td>Добавить товар в магазин</td> <td>Сообщение об успехе или ошибке</td>
  </tr>
  <tr> 
    <td>POST</td>  <td>/goods/delete</td> <td>name</td> <td>Удалить товар из магазина</td> <td>Сообщение об успехе или ошибке</td> 
  </tr>
  <tr> 
    <td>POST</td>  <td>/goods/update</td> <td>id,name,price, category</td> <td>Изменить данные товара</td> <td>Сообщение об успехе или ошибке</td> 
  </tr>
  </table>
   <div>
  Коллекция запросов для тестирования API-методов находится в файле <a href="https://github.com/elenabenken/otus1/blob/master/otus_1.postman_collection.json">otus_1.postman_collection.json </a>.
    </div>
  <h3>Сценарии использования системы</h3>
  <p>
  
  ![Image alt](https://github.com/elenabenken/otus1/raw/master/pictures/Client_Use_cases.png)
  
   <div>Рис. 2. Сценарии использования для Клиента.</div>
    </p> <p>
  
  ![Image alt](https://github.com/elenabenken/otus1/raw/master/pictures/Admin_Use_cases.png)
  
   <div>Рис. 3. Сценарии использования для Администратора.</div>
    </p> <p>
  
  ![Image alt](https://github.com/elenabenken/otus1/raw/master/pictures/Manager_Use_cases.png)
  
   <div>Рис. 4. Сценарии использования для Менеджера.</div>
    </p>
