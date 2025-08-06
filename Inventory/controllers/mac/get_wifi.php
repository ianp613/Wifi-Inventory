<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $wifi = new Wifi;
    $wifi = DB::all($wifi);

    array_push($wifi,["id" => "Show All", "name" => "Show All"]);
    $response = [
        "status" => true,
        "wifis" => $wifi
    ];    
    echo json_encode($response);
?>