<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    if($data["name"]) {
        $equipment = new Equipment;
        $bol = DB::validate($equipment,"name",$data["name"]);

        if($bol){
            $equipment = DB::prepare($equipment,$data["id"]);
            $equipment->name = $data["name"];
            DB::update($equipment);
            $response = [
                "status" => true,
                "type" => "success",
                "size" => null,
                "message" => "Equipment has been updated."
            ]; 
        }else{
            $response = [
                "status" => false,
                "type" => "warning",
                "size" => null,
                "message" => "Equipment already exist."
            ];    
        }
    }else{
        $response = [
            "status" => false,
            "type" => "warning",
            "size" => null,
            "message" => "Please provide equipment name."
        ];
    }
    echo json_encode($response);
?>