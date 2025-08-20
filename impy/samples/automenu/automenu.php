<?php
    if(!isset($_REQUEST["ajax_data"])) die();

    //------------------
    $Tabs = '<button onclick="openView(event, this)">Результат</button>';
    $cDir = __DIR__ . "/" . str_replace("round_", "", $_REQUEST["ajax_data"]);
?>