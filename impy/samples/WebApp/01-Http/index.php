<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Работа веб-приложений");
?>
<!-- //--------------// -->
<h3> HTTP и современный Web </h3>
<hr>
<!-- //--------------// --> 
<form style="background: #eeeeee; padding:8px" action="dadata.php" method="POST" target="result">
	<p class="mf-req" style="width:150px; display:inline-block;">Введите фамилию<strong>*</strong> </p>
 	<input type="text" id="lastName" name="user_last_name" style="width:250px;" value=""> <br>

	<p class="mf-req" style="width:150px; display:inline-block;">Введите имя<strong>*</strong> </p>
 	<input type="text" id="firstName" name="user_name" style="width:250px;" value=""> <br>

	<p class="mf-req" style="width:150px; display:inline-block;">Введите отчество<strong>*</strong> </p>
 	<input type="text" id="secondName" name="user_second_name" style="width:250px;" value=""> <br> 

 	<input type="hidden" name="token" value="3fa )))"> 
	<input type="hidden" name="secret" value="5711 )))"> <br>

 	<input type="submit" name="submitPOST" value="Отправить запрос методом POST"> 
	<button type="submit" formmethod="GET" name="submitGET">Отправить запрос методом GET</button>
	<!-- style="background:#00FFCC"  -->
</form>

<h4> Результат: </h4>
<iframe name="result" id="id_result" style="background-color: black; width: 100%; height: 0px;"></iframe>

<!-- //--------------// -->
<script>
	window.addEventListener('load', function () {

		let iframe = document.getElementById('id_result'); // Найдем наш iframe
		iframe.onload = function() {   // При загрузке контента
    		iframe.style.height = iframe.contentWindow.document.body.scrollHeight + 40 + 'px'; // Подгоним высоту под содержимое
		};

		// -- Сохраненные значения формы
		let lastSuorce = getCookie("PhpSourse");			
		if (lastSuorce !== null) {
			lastSuorce = decodeURIComponent(lastSuorce);
			lastSuorce = JSON.parse(lastSuorce);
			for (let key in lastSuorce) { 
				let eInput = document.getElementById(key); 
				eInput.value = lastSuorce[key];  
			}  
		}
		
		// -- Очистим строку Get параметров
		let baseUrl = window.location.href.split("?")[0];
		window.history.pushState('name', '', baseUrl);
	})

	//-------------- //-------------- //--------------
	function getCookie(name) {  
		var cookies = document.cookie.split(';');  
		for (var i = 0; i < cookies.length; i++) {  
			var cookie = cookies[i].trim();  
			if (cookie.indexOf(name) === 0) {  
				return cookie.substring(name.length + 1); 						
			}  
		} 
		//-------------- 
		return null;  
	} 
</script>
<!-- //--------------// -->
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>