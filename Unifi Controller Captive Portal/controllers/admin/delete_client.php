<?php
    include("../../includes.php");
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);

    $client = new Client;
    $clients = DB::where($client,"mac","=",$data["mac"]);
    $res = count($clients) ? DB::delete($client,$clients[0]["id"]) : null;

    echo json_encode($res);
    
?>