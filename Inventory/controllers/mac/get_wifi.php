<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $wifi = new Wifi;
    $wifi = DB::all($wifi);
    $response = [
        "status" => true,
        "wifis" => $wifi
    ];    
    echo json_encode($response);
?>