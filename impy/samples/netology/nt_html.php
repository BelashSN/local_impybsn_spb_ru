<?php
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    use Bitrix\Main\Page\Asset;
    //------------------
	$APPLICATION->SetTitle("Работа Web-приложений. Запросы HTML - JS");
	Asset::getInstance()->addCss("/local/impy/samples/netology/css/nt_query_dadata.css");
?>

<!--------------------------------------------------------------------------->
<?php include_once("nt_header.php"); ?>

<!--------------------------------------------------------------------------->
<div  id="page_body" style="height: 60vh;">
	<form id="page_form">
		<strong class="page_form_header">Информация о стране</strong>

		<p>Укажите страну поиска<strong> *</strong></p>
		<input type="text" id="country_code" value=""><br>

		<span class="page_form_description">
			Страну необходимо указать: 
			<br>Либо в виде числового кода (например 643)
			<br>Либо в виде наименования (например Казахстан)
			<br>Либо в виде двухбуквенного или трехбуквенного кода (например: US, GBR)</span><br>

		<input type="submit" id="submit" name="submit" value="Запросить данные">
  	</form>

  	<div id="page_description"> 
		<h4>Домашнее задание по теме "Запросы HTML - JS"</h4>
		<hr>
		<ol>
			<li>Зарегистрируйтесь в сервисе dadata.ru и получите API-ключ и секретный ключ</li>
			<li>Создайте html-страницу, на которой будет размещена форма для ввода пользователем следующих данных: код страны</li>
			<li>Форма должна передавать данные в формате GET-запроса</li>
			<li>После работы обработчика на странице должны быть выведены данные о стране в формате dadata.ru</li>
		</ol>
	</div>

  <div id="page_result" class="page_result"></div>
</div>

<!--------------------------------------------------------------------------->
<?php $secret = file_get_contents('security/security_dadata.txt'); ?>

<!--------------------------------------------------------------------------->
<script>
	const element = document.getElementById('submit');

	element.addEventListener('click', (event) => { 
		event.preventDefault();

		//----------------------------------
		var elmCSub = document.getElementById("submit");
		elmCSub.value = "Идет запрос...";
		elmCSub.classList.add('process');
			
		//----------------------------------
		var url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/country";		
		var query = (document.getElementById("country_code").value).toUpperCase();
		var token = "<?php echo $secret ?>";

		//----------------------------------
		var options = {
			method: "POST",
			mode: "cors",
			headers: {
				"Content-Type": "application/json",
				"Accept": "application/json",
				"Authorization": "Token " + JSON.parse(atob(token))["token"]
			},
			body: JSON.stringify({query: query})
		}
		
		//----------------------------------
		var respOk = true;
		var txtRes = "Неизвестная ошибка...";
		var elmRes = document.getElementById("page_result");
		elmRes.classList.remove('page_error');

		//----------------------------------
		fetch(url, options)
		.then((response) => {
			respOk = response.ok; 
			return response.text();
		})
		//-------------------
		.then((result) => { 
			curRes = JSON.parse(result);
			txtRes = JSON.stringify(curRes, undefined, 4);	
			if (!respOk) throw new Error(txtRes);
			if (!curRes.suggestions.length) throw new Error("Страна по указанным данным не обнаружена...");

			setTimeout(() => {
				elmCSub.value = "Запросить данные";
				elmCSub.classList.toggle('process');
				elmRes.innerHTML = "<pre style='white-space: pre-wrap;'>" + txtRes + "</pre>";	
			}, 900);		
		})
		//-------------------
		.catch((error) => {
			setTimeout(() => {
				elmCSub.value = "Запросить данные";
				elmCSub.classList.toggle('process');
				elmRes.classList.add('page_error');	
				elmRes.innerHTML = "<pre style='white-space: pre-wrap;'>" + error + "</pre>";				
        	}, 900);		
		});	
	});
</script>

<!--------------------------------------------------------------------------->
<?php 
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); 
?>

