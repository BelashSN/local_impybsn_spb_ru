<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    use Bitrix\Main\Page\Asset;
    //------------------
    $APPLICATION->SetTitle("Примеры создания скриптов на JS, jQuery, Bitrix-JS");
	$APPLICATION->SetAdditionalCss("/local/impy/samples/css/bxscripts.css");
	Asset::getInstance()->addJs("/local/impy/samples/js/bxscripts.js");
    //------------------
	CJSCore::Init(array("window"));
	\Bitrix\Main\UI\Extension::load('ui.entity-selector');
?>

<!--------------------------------------------------------------------------->
<div id="page_body" style="height: 65vh;">
    <div class="page_content">
		<div class="page_content_menu">
            <ol class="rounded">
                <li> <span>Просто пустая ссылка...</span> </li>            
                <li> <span>Просто пустая ссылка...</span> </li>
                <li> <span>Просто пустая ссылка...</span> </li>
                <li> <span class="opening" onClick="roundedRowClick(this)">
					Раскрывающаяся ссылка с примерами - просто по-приколу</span>
                    <div id="roundedRowText"> 
                        <br><strong>Примеры вызова некоторых компонент Битрикс:</strong>
						<hr><br>
						<button id="selectButton">Выбор контакта</button>
						<button id="popupButton">Всплавающее окно</button>
                    </div>
                </li>
            </ol>
        </div>

		<!--------------------------------------------------------------------------->
		<div class="page_content_view">
            <h3>Тут обязательно будет результат....</h3>
            <br><hr>
        </div>
    </div>
</div>

<!--------------------------------------------------------------------------->
<script>
    function roundedRowClick(e) {
        if(BX.isNodeHidden(BX("roundedRowText"))) BX.show(BX("roundedRowText"));
        else BX.hide(BX("roundedRowText"));
    };
</script>

<!--------------------------------------------------------------------------->
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>