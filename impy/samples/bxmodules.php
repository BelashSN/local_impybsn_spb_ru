<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	//------------------
    $APPLICATION->SetTitle("Примеры создания собственных модулей");
	$APPLICATION->SetAdditionalCSS('/local/impy/samples/css/bxmodules.css');
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
				<li> <span>Просто пустая ссылка...</span> </li>
			</ol>
		</div>

		<!--------------------------------------------------------------------------->
		<div class="page_content_view">
			<?$APPLICATION->IncludeComponent(
				"samples:user.card",
				"",
				Array(
					"SHOW_EMAIL" => "Y",
					"USER_ID" => "1"
				)
			);?>
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
<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>