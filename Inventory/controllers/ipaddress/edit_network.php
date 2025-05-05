<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    if($data["name"]) {
        $network = new IP_Network;
        $bol = DB::validate($network,"name",$data["name"]);

        if($bol){
            DB::prepare($network,$data["id"]);
            $network->name = $data["name"];
            $network->subnet = $data["subnet"];
            DB::update($network);

            $ip = new IP_Address;
            $ip_temp = DB::where($ip,"nid","=",$data["id"]);
            foreach ($ip_temp as $ip_t) {
                $ip = DB::prepare($ip,$ip_t["id"]);
                $ip->subnet = $data["subnet"];
                $ip->status = $ip_t["status"];
                DB::update($ip);
            }
            $response = [
                "status" => true,
                "type" => "success",
                "size" => null,
                "message" => "Data Updated",
            ]; 
        }else{
            $response = [
                "status" => false,
                "type" => "warning",
                "size" => null,
                "message" => "Network already exist."
            ];    
        }
    }else{
        $response = [
            "status" => false,
            "type" => "warning",
            "size" => null,
            "message" => "Please provide network name."
        ];
    }
    echo json_encode($response);
?>