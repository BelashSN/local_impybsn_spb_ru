<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Домашние задания модуля: Работа веб-приложений");
?>
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ===================================== -->
    <style type="text/css">
        .rounded {
        counter-reset: li; 
        list-style: none; 
        font: 14px "Trebuchet MS", "Lucida Sans";
        padding: 0;
        text-shadow: 0 1px 0 rgba(255,255,255,.5);
        }
        .rounded a {
        position: relative;
        display: block;
        padding: .4em .4em .4em 3em;
        margin: .8em 1.5em;
        background: #DAD2CA;
        color: #444;
        text-decoration: none;
        border-radius: .3em;
        transition: .3s ease-out;
        }
        .rounded a:hover {background: #E9E4E0;}
        .rounded a:hover:before {transform: rotate(360deg);}
        .rounded a:before {
        content: counter(li);
        counter-increment: li;
        position: absolute;
        left: -1.5em;
        top: 50%;
        text-indent: .1em;
        padding-right: -12.5em;
        margin-top: -1.3em;
        background: #8FD4C1;
        height: 2em;
        width: 2em;
        line-height: 2em;
        border: .3em solid white;
        text-align: center;
        font-weight: bold;
        border-radius: 2em;
        transition: all .3s ease-out;
        }
    </style>
</head>

<ol class="rounded">
    <li><a href="./01-Http/index.php" target="_self">HTTP и современный Web</a></li>
    <li><a href="./02-jQuery/index.php" target="_self">Библиотека JQuery</a></li>
    <li><a href="./03-BitrixJs/index.php" target="_self">Библиотека Bitrix JS</a></li>
    <li><a href="./04-Rest-Api/index.php" target="_self">Примеры REST API</a></li>
    <li><a href="./05-Json/index.php" target="_self">Форматы обмена данными JSON, XML</a></li>
    <li><a href="./06-MySQL/index.php" target="_self">Соединение с СУБД MySQL</a></li>
</ol>			


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>