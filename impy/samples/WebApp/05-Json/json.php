<?
	$arUserInfo = []; 
	// Обходим суперглобальный массив полей запроса по парам Ключ-Значение
	foreach($_REQUEST as $key => $value){
		// Исключим из массива ответа поле кнопки submit
		if($key === "submit") continue;
		// Создадим элемент массива ответа, исключив слово user из имени ключа
		$arUserInfo[str_ireplace("_", " ", str_ireplace("user_", "", subject: $key))] = $value;
	}		

	// Преобразуем полученный массив в строку json, с флагами: Запретить символы Юникода и Форматирование строки
    ob_start();
    var_dump($_REQUEST);
    $response = array(
        'ParamRequest' => ob_get_clean(),
        'ResultRequest' => json_encode($arUserInfo, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
     );  

	echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>