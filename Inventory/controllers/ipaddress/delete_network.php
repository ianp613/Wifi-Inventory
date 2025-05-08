<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    if($data["id"]){
        $ip = new IP_Address;
        $ip_temp = DB::where($ip,"nid","=",$data["id"]);
        foreach ($ip_temp as $i) {
            DB::delete($ip,$i["id"]);
        }

        $network = new IP_Network;
        DB::delete($network,$data["id"]);

        $response = [
            "status" => true,
            "type" => "info",
            "size" => null,
            "message" => "Network has been deleted."
        ];
    }else{
        $response = [
            "status" => false,
            "type" => "error",
            "size" => null,
            "message" => "Network not found."
        ];
    }
        
    echo json_encode($response);
?>