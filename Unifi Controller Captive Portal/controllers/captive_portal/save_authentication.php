<?php
    include("../../includes.php");
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);

    // find client ID
    $client = new Client;
    $client = DB::where($client,"mac","=",$data["mac"]);
    $cid = count($client) ? $client[0]["id"] : null;

    // find voucher ID
    $voucher = new Voucher;
    $voucher = DB::where($voucher,"code","=",$data["code"]);
    $vid = count($voucher) ? $voucher[0]["id"] : null;
    
    $authentication = new Authentication;
    $authentication->cid = $cid;
    $authentication->vid = $vid;
    $authentication->target = $data["target"];
    $authentication->type = $data["type"];
    DB::save($authentication);
    
    // if(DB::validate($client,"mac",$data["mac"])){
    //     DB::save($client);    
    // }else{
    //     $client_data = DB::where($client,"mac","=",$data["mac"])[0];
    //     $client = DB::prepare($client,$client_data["id"]);
    //     $client->time = $data["date_time"];
    //     DB::update($client);
    // }
    
    echo json_encode($authentication);
    
?>