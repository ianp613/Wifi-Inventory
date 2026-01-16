<?php
    include("../../includes.php");
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);

    $lockout = new Lockout;
    $client = DB::where($lockout,"mac","=",$data["mac"],"desc");

    if(!count($client)){
        $lockout->mac = $data["mac"];
        $lockout->time = "-";
        $lockout->attempt = 0;
        DB::save($lockout);
    }

    $now = new DateTime('now', new DateTimeZone('Asia/Manila'));
    $datetime = $now->format('Y-m-d H:i:s');

    if($data["type"] == "post" && count($client)){
        $client_temp = DB::prepare($lockout,$client[0]["id"]);
        $client_temp->attempt = (int) $client_temp->attempt < 3 ? (int) $client_temp->attempt + 1 : 3;
        if($client_temp->attempt == 3 && $client_temp->time == "-"){
            $client_temp->time = $datetime;
        }
        DB::update($client_temp);
    }elseif($data["type"] == "reset" && count($client)){
        $client_temp = DB::prepare($lockout,$client[0]["id"]);
        $client_temp->attempt = "0";
        $client_temp->time = "-";
        DB::update($client_temp);
    }

    $response = [
        "client" => $client = DB::where($lockout,"mac","=",$data["mac"],"desc")
    ];
    
    echo json_encode($response);
    
?>