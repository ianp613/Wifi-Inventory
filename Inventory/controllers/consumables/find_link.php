<?php
    session_start();
    header('Content-Type: application/json');
    include("../../includes.php");
    $response = [
        "status" => false,
        "link" => ""
    ];

    if($_SESSION["g_member"]){

    }

    echo json_encode($response);
?>