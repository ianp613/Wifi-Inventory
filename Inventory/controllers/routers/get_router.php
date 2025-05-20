<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $router = new Routers;
    $router = DB::all($router);
    $response = [
        "status" => true,
        "router" => $router
    ];    
    echo json_encode($response);
?>