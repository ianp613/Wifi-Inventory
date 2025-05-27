<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);
    
    $router = new Routers;
    $router = DB::all($router);
    echo json_encode($router);
?>