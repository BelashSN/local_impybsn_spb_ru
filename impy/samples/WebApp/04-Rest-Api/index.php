<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Работа веб-приложений");
?>
<!-- //--------------// -->
<h3> Примеры REST API </h3>
<hr>
<!-- //--------------// --> 
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="ajax_rest.js"></script>
	<!-- ===================================== -->
    <style type="text/css">		
		#result {
			display: none;
		}
		#general {
			height: 50px;
			padding: 5px;
			overflow-y: auto;
		}
		#advansed {
			height: 200px;
			padding: 5px;
			overflow-y: auto;
		}		
	</style>
</head>
<!-- //--------------// -->
<form action="" method="POST" style="background: #eeeeee; padding: 8px;">
    <strong>Запрос адреса по IP...</strong><br><br>
    <label>Укажите IP<strong class="mf-req">*</strong></label>
    <input type="text" name="ip" id="ip" value=""><br><br>

    <input type="submit" name="submit" id="submit" value="Запросить параметры адреса"><br>
</form>
<!-- //--------------// -->
<div id="result"> 
	<br><strong>Результат:</strong>
	<br><br><div id="general"></div>
	<br><strong>Дополнительная информация:</strong>
	<br><br><div id="advansed"></div>
</div>
<!-- //--------------// -->
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>