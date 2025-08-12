<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    $consumables = new Consumables;
    $consumables = DB::all($consumables);

    
    $response = [
        "status" => true,
        "consumables" => $consumables,
    ];
        
    echo json_encode($response);
?>