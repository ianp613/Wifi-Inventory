<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    $user = new User;
    DB::delete($user,$data["id"]);

    $response = [
        "status" => true,
        "type" => "info",
        "message" => "User account has been deleted."
    ];

    echo json_encode($response);