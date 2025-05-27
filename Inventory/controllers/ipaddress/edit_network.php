<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    if($data["name"]) {
        $network = new IP_Network;
        
        DB::prepare($network,$data["id"]);
            $network->name = $data["name"];
            $network->subnet = $data["subnet"];
            $network->rid = $data["gateway"];
            DB::update($network);

            $ip = new IP_Address;
            $ip_temp = DB::where($ip,"nid","=",$data["id"]);
            foreach ($ip_temp as $ip_t) {
                $ip = DB::prepare($ip,$ip_t["id"]);
                $ip->subnet = $data["subnet"];
                $ip->status = $ip_t["status"];
                DB::update($ip);
            }
            $net = DB::where($network,"name","=",$data["name"]);
            if(count($net) > 1){
                $response = [
                    "status" => true,
                    "type" => "warning",
                    "size" => null,
                    "message" => "Data has been updated. Please note that the ".$data["name"]." network already exists, which may lead to potential conflicts or data integrity issues."
                ]; 
            }else{
                $response = [
                    "status" => true,
                    "type" => "success",
                    "size" => null,
                    "message" => "Network has been updated.",
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