<?
    require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); 
    //------------------   
    $APPLICATION->SetTitle("Последние новости");
    $APPLICATION->SetAdditionalCSS('/local/impy/desktop/css/news.css');
    //------------------ CJSCore::Init(array("jquery3"));	
?>

<!--------------------------------------------------------------------------->
<? include_once("header.php"); ?>

<!--------------------------------------------------------------------------->
<div id="page_body" style="height: 65vh;">
    <div class="news_content">
        <h3 class="news_content_header">Тут обязательно будет список новостей....</h3>
        <hr>
        <br />  <br /> <br />
        <hr>
        <br />  <br /> <br />
        <hr>
        <br />  <br /> <br />
        <hr>
        <br />  <br /> <br />
        <hr>
        <br />  <br /> <br />
        <hr>
    </div>
</div>

<!--------------------------------------------------------------------------->
<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>