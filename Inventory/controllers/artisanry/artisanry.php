<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);


    $response = [
        "status" => true,
        "message" => "QR CODE",
        // "QR" => QR::create("TEXT QR")
    ];    
    echo json_encode($response);
?>