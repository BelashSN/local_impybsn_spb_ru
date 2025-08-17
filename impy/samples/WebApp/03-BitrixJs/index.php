<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Работа веб-приложений");

//подключаем Bitrix JS ядро и библиотеку ajax
CJSCore::Init(array('ajax'));
//определим колнтрольное значение парамметра
$sidAjax = 'testAjax';

/* если на сервер произвольным методом был передан параметр 
ajax_form и его значение совпадает с контрольным */
if(isset($_REQUEST['ajax_form']) && $_REQUEST['ajax_form'] == $sidAjax){
    //сбросим буфер вывода для возврата результата запроса
    $GLOBALS['APPLICATION']->RestartBuffer();

    /* выведем результат (ответ сервеа) в виде объекта JS, 
    полученного из массива php с полями RESULT и ERROR */
    echo CUtil::PhpToJSObject(array(
        'RESULT' => 'HELLO. Result from Bitrix server is TRUE ...',
        'ERROR' => ''
    ));
    //завершение работы серверного скрипта
    die();
}
?>
<!-- //--------------// -->
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="bitrix.css" />
	<meta name="viewport" content="width=device-width, initial-scale=1">    
</head>
<!-- //--------------// -->
<h3> Библиотека Bitrix JS </h3>
<hr>
<!-- //--------------// --> 
<!-- создадщим на странице группу из двух блоков: Ожтдание и результат -->
<div class="group">   
    <a href="#" class="css_ajax">Click me</a>   
    <div id="block"></div >
    <div id="process">WAIT... Requesting ... </div >
</div>

<script>
   //включим отладку 
   window.BXDEBUG = true;
   
   //фунция загрузки данных с сервера по запросу ajax
   function DEMOLoad(){
      //скроем блок результата на странице
      BX.hide(BX("block"));
      //покажем блок ожидания на странице
      BX.show(BX("process"));

      /* выполним GET-запрос с кобственной странице с передачей параметра 
      ajax_form и его значением, взятым из контрольный переменной */
      BX.ajax.loadJSON(
        '<?=$APPLICATION->GetCurPage()?>?ajax_form=<?=$sidAjax?>',
        DEMOResponse // определим callback функцию, принимающую результат запроса
      );  
   }

   //callback фунция, обрабатывающая результат ajax запроса
   function DEMOResponse (data){
        //выведем результвт запроса в консоль для проверки
        BX.debug('AJAX-DEMOResponse ', data);
        //установим значения блока страницы - результат
        BX("block").innerHTML = data.RESULT;

        setTimeout(() => {
            //покажем блок результата на странице
            BX.show(BX("block"));
            //скроем блок ожидания на странице
            BX.hide(BX("process"));
        }, 1200);      

      //вызов на выполнение события разработчка, которе в коде почему-то закомментировано
      //интересно - Битрикс так выдаст ошибку?
      BX.onCustomEvent(
         BX(BX("block")),
         'DEMOUpdate'
      );
   }

   //обработчик события, когда DOM-структура полностью загружена
   BX.ready(function(){
      //скроем блок результата на странице
      BX.hide(BX("block"));
      //скроем блок ожидания на странице
      BX.hide(BX("process"));
      
      //установим событие click на дочерние элементы тела документа,
      //содержащие класс css_ajax 
      BX.bindDelegate(
         document.body, 'click', {className: 'css_ajax' },        
         function(e){  // опишем callback функцию, вызываемкю при клике на css_ajax
            //если событие тела не передано, определим событие окна
            if(!e) e = window.event;
            //вызовем функцию загрузки  данных с сервера
            DEMOLoad();
            //отменим стандарное выоблнение обработика клик на css_ajax
            return BX.PreventDefault(e);
         }
      );
   });
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>