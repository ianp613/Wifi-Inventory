<?php
    include("../../includes.php");
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);

    $client = new Client;
    $client = DB::where($client,"mac","=",$data["mac"],"desc");
    $cid = count($client) ? $client[0]["id"] : null;

    $authenticaion = new Authentication;
    $authenticaion = DB::where($authenticaion,"cid","=",$cid,"created_at","desc");

    $response = [
        "status" => count($authenticaion) ? true : false,
        "authentication" => $authenticaion[0],
        "client" => $client
    ];
    echo json_encode($response);
    
?>