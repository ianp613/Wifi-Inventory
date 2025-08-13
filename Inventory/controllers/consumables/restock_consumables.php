<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);
    
    $consumables = new Consumables;
    $consumables = DB::prepare($consumables,$data["sid"]);

    $consumables->stock += $data["quantity"];
    DB::update($consumables);

    $response = [
        "status" => true,
        "type" => "success",
        "size" => null,
        "message" => "Stock has been added.",
    ];

    echo json_encode($response);

?>