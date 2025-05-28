<?php
    header('Content-Type: application/json');
    session_start();
    include("../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    $setting = new Settings;
    if($data["type"] == "sound"){
        $sound = DB::prepare($setting,1);
        $sound->sound = $sound->sound == 1 ? 0 : 1;
        DB::update($sound);
    }

    if($data["type"] == "theme"){
        $theme = DB::prepare($setting,1);
        $theme->theme = $theme->theme == 1 ? 0 : 1;
        DB::update($theme);
    }
    

    echo json_encode(DB::all($setting)[0]);
?>
