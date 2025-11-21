<?php
    include("../../includes.php");
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);

    

    $client = new Client;
    $client->name = $data["hostname"];
    $client->mac = $data["mac"];
    $client->time = $data["date_time"];

    if(DB::validate($client,"mac",$data["mac"])){
        DB::save($client);    
    }else{
        $client_data = DB::where($client,"mac","=",$data["mac"])[0];
        $client = DB::prepare($client,$client_data["id"]);
        $client->time = $data["date_time"];
        DB::update($client);
    }
    
    echo json_encode("You can now access the internet!");
    
?>