<?php
    if(!isset($_REQUEST["ajax_data"])) die();
    if(!isset($_REQUEST["component"])) die();

    //------------------ //------------------
    function files_recursion($curDir, $allFiles)  {
        $curFiles = scandir($curDir);
        foreach($curFiles as $fileName) {
            if ($fileName === "." || $fileName === "..") continue;
            //------------------
            if(is_dir($curDir . $fileName)) {
                $allFiles = files_recursion($curDir . $fileName . "/", $allFiles);
            }
            else  {                
                $thisId = str_replace(".", "_", $fileName);
                $thisData = file_get_contents($curDir . $fileName);
                //------------------
                $allFiles[] = [                    
                    "id"    => "menu_file_" . $thisId,
                    "name"  => $fileName,
                    "data"  => $thisData
                ];
            }
        }
        //------------------
        return $allFiles;
    }

    //------------------ //------------------    
    $genFileName = str_replace("round_scr_", "", $_REQUEST["ajax_data"]);
    $genFileName = str_replace("round_comp_", "", $genFileName);
    
    //------------------
    if($_REQUEST["component"] === "true") {
        //$compName = str_replace("_~", ".", $_REQUEST["ajax_data"]);
        $curDir = dirname(__DIR__, 2) . "/components/samples/" . $genFileName . "/";
    }
    else {
        $curDir = __DIR__ . "/" . $genFileName . "/";
    }

    //------------------
    $dataFiles = files_recursion($curDir, []);

    //------------------
    $menuList = "";
    foreach($dataFiles as $curData) {
        $menuList .= '<li class="tabview_button" id="' . $curData["id"] 
        . '" onclick="openMenuView(this)">' . $curData["name"] . '</li>';
    }

    //------------------
    $aResult = [
        "MENU" => $menuList,
        "DATA" => $dataFiles
    ];

    //------------------
    $ResPagePhp = file_get_contents(__DIR__ . "/_results/res_" . $genFileName . ".php");
    $ResPageJS = file_get_contents(__DIR__ . "/_results/res_" . $genFileName . ".js");

    //------------------
    if(!!$ResPageJS) $aResult["SCRIPT"] = $ResPageJS;
    if (!!$ResPagePhp) $aResult["RESP"] = $ResPagePhp;
    else $aResult["ERR"] = "Не удалось получить итоговые данные\n" 
    . __DIR__ . "/_results/res_" . $genFileName . ".php";

    //------------------
    echo json_encode($aResult);
    //------------------
    die();
