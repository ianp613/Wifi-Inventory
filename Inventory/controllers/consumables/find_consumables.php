<?php
    session_start();
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    if($data["id"]) {
        $consumables = new Consumables;
        if($_SESSION["g_id"]){
            $consumables = DB::find($consumables,$data["id"]);
            $temp = [];
            foreach ($consumables as $cons) {
                // IF GID IS EQUAL TO GID
            }
            $consumables = $temp;
        }else{
            $consumables = DB::find($consumables,$data["id"]);
        }
        
        $response = [
            "status" => true,
            "type" => "info",
            "size" => null,
            "message" => "Edit consumable with ID ".$data["id"],
            "consumable" => $consumables
        ];
    }else{
        $response = [
            "status" => false,
            "type" => "error",
            "size" => null,
            "message" => "Entry not found."
        ];
    }
    echo json_encode($response);
?>