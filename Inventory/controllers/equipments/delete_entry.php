<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    if($data["id"]){
        $entry = new Equipment_Entry;
        DB::delete($entry,$data["id"]);
        $response = [
            "status" => true,
            "type" => "info",
            "size" => null,
            "message" => "Entry deleted."
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