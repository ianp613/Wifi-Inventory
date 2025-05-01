<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $equipment = new Equipment;
    $equipment = DB::all($equipment);
    $response = [
        "status" => true,
        "equipments" => $equipment
    ];    
    echo json_encode($response);
?>