<?php
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle("Title");
?>

<?php
    $APPLICATION->IncludeComponent(
        "samples:user.card",
        "",
		Array(
			"SHOW_EMAIL" => "Y",
			"USER_ID" => "1"
		)
	);
?>

<?php 
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); 
?>