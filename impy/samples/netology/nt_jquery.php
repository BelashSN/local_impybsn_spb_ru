<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    use Bitrix\Main\Page\Asset;
    //------------------
    $APPLICATION->SetTitle("Работа Web-приложений. Библиотека JQuery");
	Asset::getInstance()->addJs("/local/impy/samples/netology/js/nt_jquery.js");
	Asset::getInstance()->addCss("/local/impy/samples/netology/css/nt_query_dadata.css");
	//------------------
	CJSCore::Init(array("jquery3"));
?>

<!--  пример получения из сети ------------------------------------ 
<script
	src="https://code.jquery.com/jquery-3.3.1.min.js"
	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
	crossorigin="anonymous">
</script> 
-->

<!--------------------------------------------------------------------------->
<? include_once("nt_header.php"); ?>

<!--------------------------------------------------------------------------->
<div  id="page_body" style="height: 60vh;">
	<form id="page_form">
		<strong class="page_form_header">Стандартизация ФИО</strong>

		<p>Введите фамилию<strong>*</strong></p>
		<input type="text" id="user_last_name" value=""><br>
	
		<p>Введите имя<strong>*</strong></p>
		<input type="text" id="user_name" value=""><br>

		<p>Введите отчество<strong>*</strong></p>
		<input type="text" id="user_second_name" value=""><br><br>

		<input type="submit" id="submit" name="submit" value="Запросить данные">
  	</form>

  	<div id="page_description"> 
		<h4>Домашнее задание по теме "JQuery"</h4>
		<hr>
		<ol>
			<li>За основу возьмите файлы form_ajax.html и form_ajax.js из репозитория</li>
			<li>Добавьте в передаваемые на сервер данные Отчество</li>
			<li>Выведите в console значение value</li>
			<li>Добавьте в файле form_ajax.js вывод Фамилии, имени и отчества отдельными строчками по аналогии с уже выводимыми данными.</li>
		</ol>
	</div>

  <div id="page_result" class="page_result"></div>
</div>

<!--------------------------------------------------------------------------->
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>