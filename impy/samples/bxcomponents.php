<?php
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	//------------------
    $APPLICATION->SetTitle("Примеры создания собственных компонентов");
	$APPLICATION->SetAdditionalCSS('/local/impy/samples/bxmain.css');
	//------------------
	use Bitrix\Main\Page\Asset; // new
	Asset::getInstance()->addJs("/local/impy/samples/bxmain.js"); 
    //------------------
	CJSCore::Init(array("window", "ajax"));
	\Bitrix\Main\UI\Extension::load('ui.entity-selector');
?>

<!--------------------------------------------------------------------------->
<div id="page_body" style="height: 60vh;">
	<div class="page_content">
		<div class="page_content_menu">
            <ol class="rounded">
                <li> <span id="round_comp_user.card" onClick="roundedRowClick(this)">
                    Карточка пользователя по id...</span></li>            
                <li> <span onClick="roundedRowClick(this)">Пустая ссылка...</span></li>
                <li> <span id="round_opening" onClick="roundedRowOpenedClick(this)">
					Примеры программного вызова компонентов Битрикс</span>
                    <div id="roundedRowText"> 
						<hr>
						<button id="selectButton">Выбор контакта</button>
						<button id="popupButton">Всплавающее окно</button>
                    </div>
                </li>
            </ol>
        </div>

        <!--------------------------------------------------------------------------->
		<div id="page_content_view">
            <div id="page_content_header">
                <strong id="page_button_menu" class="lock_button_menu" 
                    onClick="pageContentMenuClick(this)"> &nbsp;☰&nbsp;
                </strong>
                <strong id="page_content_caption">
                    Компонент для просмотра не выбран...
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