<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $user = new User;
    $user = DB::all($user);
    $response = [
        "status" => true,
        "user" => $user,
    ];

    echo json_encode($response);
?>