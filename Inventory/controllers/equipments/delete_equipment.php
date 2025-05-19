<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    if($data["id"]){
        $entry = new Equipment_Entry;
        $entry_temp = DB::where($entry,"eid","=",$data["id"]);
        foreach ($entry_temp as $i) {
            DB::delete($entry,$i["id"]);
        }

        $equipment = new Equipment;
        DB::delete($equipment,$data["id"]);

        $response = [
            "status" => true,
            "type" => "info",
            "size" => null,
            "message" => "Equipment has been deleted."
        ];
    }else{
        $response = [
            "status" => false,
            "type" => "error",
            "size" => null,
            "message" => "Equipment not found."
        ];
    }
        
    echo json_encode($response);
?>