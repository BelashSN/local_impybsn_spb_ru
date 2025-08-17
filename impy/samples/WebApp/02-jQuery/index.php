<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Работа веб-приложений");
?>
<!-- //--------------// -->
<h3> Библиотека JQuery </h3>
<hr>
<!-- //--------------// --> 
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- //--------------// -->
	<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script-->
	<!-- //--------------// -->
	<script
		src="https://code.jquery.com/jquery-3.3.1.min.js"
		integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
		crossorigin="anonymous">
	</script>
	<script src="form_ajax.js"></script>
</head>
<!-- //--------------// -->
<form style="padding: 8px; background: #eeeeee;" action="" method="POST">
<p class="mf-req" style="width:150px; display:inline-block;">Введите фамилию<strong>*</strong></p>
	<input type="text" id="user_last_name" style="width:250px;" value=""><br>
	
<p class="mf-req" style="width:150px; display:inline-block;">Введите имя<strong>*</strong></p>
	<input type="text" id="user_name" style="width:250px;" value=""><br>

	<p class="mf-req" style="width:150px; display:inline-block;">Введите отчество<strong>*</strong></p>
	<input type="text" id="user_second_name" style="width:250px;" value=""><br><br>

	<input style="margin-left: 10px; " type="submit" name="submit" id="submit" value="Запросить данные">
</form>
<!-- //--------------// -->
<br>
<div style="padding: 8px; background: #eeeeee" id="result">Запрос не выполнялся</div>
<!-- //--------------// -->
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>