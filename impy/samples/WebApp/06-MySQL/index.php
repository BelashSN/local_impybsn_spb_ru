<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Работа веб-приложений");
CJSCore::Init(array('ajax', 'popup' ));
?>

<!-- //--------------// -->
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="mySql.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" 
	integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
	crossorigin="anonymous"></script>
	<script src="mySql.js"></script>
</head>

<!-- //--------------// -->
<h3> Заказы в СУБД MySQL </h3>
<hr>

<!-- Панель инструментов -->
<div class='orders_toolbar'>
  <div class='orders_tool_panel'>
    <button class='tool_buttons' id='orders_add' onclick="bitrixPopup()">➕ Создать</button>
    <button class='tool_buttons' id='orders_delete'>&#x274C; Удалить</button>
    <span id='orders_navigator_selected'>Выделено:</span>       
    <button id='orders_search_clear'>x</button>
    <input type='text' id='orders_toolbar_search'/>
  </div>
</div>

<!-- Панель навигации -->
<div class='orders_navigator'>  
  <div class='orders_tool_panel'>
    <div id='orders_navigator_total'>Показано:</div> 
    <div id='orders_navigator_panel'>
      <div class='nav_buttons' id='orders_navigator_start' style="font-family: 'Arial', 'Verdana'"> ⏮︎ </div>
      <div class='nav_buttons' id='orders_navigator_prev' style="font-family: 'Arial', 'Verdana'">⏴︎</div>
      <div id='orders_navigator_type'>Показать все</div>
      <div class='nav_buttons' id='orders_navigator_next' style="font-family: 'Arial', 'Verdana'">⏵︎</div>
      <div class='nav_buttons' id='orders_navigator_end' style="font-family: 'Arial', 'Verdana'";> &#x23ED; </div>
    </div>    
  </div>
</div>

<!-- Таблица заказов -->
<table id='orders'>
  <colgroup>
    <col style='width: 1%;'>
    <col style='width: 5%;'>
    <col style='width: 27%;'>
    <col style='width: 43%;'>
    <col style='width: 12%;'>
    <col  style='width: 12%;'>
  </colgroup>
  <thead>
    <tr>
      <th><input type='checkbox'></th>
      <th class='th_sort'>Id</th>
      <th class='th_sort'>Клиент</th>
      <th class='th_sort'>Адрес доставки</th>
      <th class='th_sort'>Создан</th>
      <th class='th_sort'>Доставлен</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

<!-- Панель результатов -->
<div id='orders_result' style='margin-top: 20px; padding: 10px;'>
  Результат...
</div>

<!-- Форма нового заказа -->
<div class='orders_popup_bg'>
     <div class='orders_popup'>
       
       <!-- Шапка формы нового заказа -->
       <div class='orders_popup_header'>
         <strong>Создание нового заказа</strong>
         <span class='orders_popup_close'>&#x274C;</span>
       </div>

       <!-- Тело формы нового заказа -->
       <form action='' id='orders_popup_form' method='POST'>
         <div class='orders_popup_block'>
           <legend><strong>Контактная информация:</strong></legend>
           <p>Логин (email)<strong>*</strong></p>
           <input type='email' name='client_login' value=''>
           <p>Фамилия<strong>*</strong></p>
           <input type='text' name='client_last_name' value=''>
           <p>Имя<strong>*</strong></p>
           <input type='text' name='client_name' value=''>
           <p>Отчество<strong>*</strong></p>
           <input type='text' name='client_second_name' value=''>
           <br><br>
           <legend><strong>Адрес доставки:</strong></legend>
           <p>Город<strong>*</strong></p>
           <input type='text' name='client_city' alue=''>
           <p>Улица<strong>*</strong></p>
           <input type='text' name='client_street'value=''>
           <p>Номер дома<strong>*</strong></p>
           <input type='number' name='client_house'value=''>
           <p>Квартира<strong>*</strong></p>
           <input type='number' name='client_room' value=''><br><br>
         </div>

         <!-- Подвал формы нового заказа -->
         <div class='footer'>        
           <button class='opc_btn' id='orders_popup_submit'>
             &#x2705; Создать</button>
           <button class='opc_btn orders_popup_close'>
             &#x274C; Отмена</button>         
         </div>
       </form>
     </div>
</div>

<!-- //--------------// -->
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>