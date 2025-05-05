<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $network = new IP_Network;
    $network = DB::all($network);
    $response = [
        "status" => true,
        "networks" => $network
    ];    
    echo json_encode($response);
?>