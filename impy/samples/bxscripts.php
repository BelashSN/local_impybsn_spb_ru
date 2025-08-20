<?php
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    //------------------
    $APPLICATION->SetTitle("Примеры создания скриптов на JS, jQuery, Bitrix-JS");
	$APPLICATION->SetAdditionalCss("/local/impy/samples/bxmain.css");
    $APPLICATION->AddHeadScript("/local/impy/samples/bxmain.js" ); // old
    //------------------
	CJSCore::Init(array("window", "ajax"));
	\Bitrix\Main\UI\Extension::load("ui.entity-selector");
?>

<!--------------------------------------------------------------------------->
<div id="page_body" style="height: 60vh;">
    <div class="page_content">
		<div class="page_content_menu">
            <ol class="rounded">
                <li> <span id="round_scr_automenu" onClick="roundedRowClick(this)">
                    Автоматическое создание меню из инфоблоков...</span></li>            
                <li> <span onClick="roundedRowClick(this)">Пустая ссылка...</span></li>
                <li> <span onClick="roundedRowClick(this)">Пустая ссылка...</span></li>
            </ol>
        </div>

        <!--------------------------------------------------------------------------->
		<div id="page_content_view">
            <div id="page_content_header">
                <strong id="page_button_menu" class="lock_button_menu" 
                    onClick="pageContentMenuClick(this)"> &nbsp;☰&nbsp;
                </strong>
                <strong id="page_content_caption">
                    Скрипт для просмотра не выбран...
                </strong>
            </div>
            <hr>
            <div id="page_menu_dropdown"> </div>
            <div id="page_content_error"></div>
            <div id="page_content_result"></div>
        </div>
    </div>
</div>

<!--------------------------------------------------------------------------->
<?php
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>