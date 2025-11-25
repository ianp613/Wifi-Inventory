<?php
    include("../../includes.php");
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);

    $client = new Client;
    $client = DB::where($client,"mac","=",$data["mac"],"desc");
    $cid = count($client) ? $client[0]["id"] : null;

    $authentication = new Authentication;
    $authentication = DB::where($authentication,"cid","=",$cid,"created_at","desc");

    $response = [
        "status" => count($authentication) ? true : false,
        "authentication" => count($authentication) ? $authentication[0] : null,
        "client" => $client
    ];
    echo json_encode($response);
    
?>