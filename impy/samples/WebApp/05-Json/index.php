<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Работа веб-приложений");
?>
<!-- //--------------// -->
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="json.css" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- //--------------// -->
	<script
		src="https://code.jquery.com/jquery-3.3.1.min.js"
		integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
		crossorigin="anonymous">
	</script>
	<script src="json.js"></script>
</head>
<!-- //--------------// -->
<h3> Форматы обмена данными JSON, XML </h3>
<hr>
<!-- Описание формы -->
<form action="" id="myForm" method="POST" style="background: #eeeeee; padding: 8px;">
	<div class="size_block">
		<legend><strong>Контактная информация:</strong></legend><br>
	
		<p class="mf-req" style="width:120px; display:inline-block;">Ваша фамилия<strong>*</strong></p>
		<input type="text" name="user_last_name" id="user_last_name" style="width:250px;" value=""><br>

		<p class="mf-req" style="width:120px; display:inline-block;">Ваше имя<strong>*</strong></p>
		<input type="text" name="user_name" id="user_name" style="width:250px;" value=""><br>

		<p class="mf-req" style="width:120px; display:inline-block;">Ваше отчество<strong>*</strong></p>
		<input type="text" name="user_second_name" id="user_second_name" style="width:250px;" value=""><br>

		<p class="mf-req" style="width:120px; display:inline-block;"> <strong></strong></p><br>

		<p><legend><strong>Адрес доставки:</strong></legend></p>

		<p class="mf-req" style="width:120px; display:inline-block;">Ваш город<strong>*</strong></p>
		<input type="text" name="user_city" style="width:250px;" value=""><br>

		<p class="mf-req" style="width:120px; display:inline-block;">Ваша улица<strong>*</strong></p>
		<input type="text" name="user_street" style="width:250px;" value=""><br>
	
		<p class="mf-req" style="width:120px; display:inline-block;">Ваш дом<strong>*</strong></p>
		<input type="number" name="user_house" style="width:250px;" value=""><br>
	
		<p class="mf-req" style="width:120px; display:inline-block;">Ваша квартира<strong>*</strong></p>
		<input type="number" name="user_room" style="width:250px;" value=""><br><br>
	</div>

	<br>
	<input type="submit" name="submit" id="submit" value="Отправить запрос">
</form>
<!-- //--------------// -->
<br>
<div class="tab">	
	<button name="Result" class="tablinks active">Результат запроса</button>
	<button name="Param" class="tablinks">Параметры запроса</button>
</div>
<!-- //--------------// -->
<div style="font-size: 14px" id="ResultRequest" class="tabContent">
  	Запрос не выполнялся
</div>
<div style="font-size: 14px" id="ParamRequest" class="tabContent">
	<?		
		echo "<pre>"; // Начало вывода форматированного текста (значения полей формы)			
		var_dump($_REQUEST);	// Вывод на экран полей формы (массив полей, переданных произвольным методом)		
		echo "</pre>"; // Окончание вывода форматированного текста
	?>
</div>


<!-- //--------------// -->
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>