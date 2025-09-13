<?php
    session_start();
    header('Content-Type: application/json');
    include("../../includes.php");
    $response = [
        "operate_as" => $_SESSION["operate_as_group"]
    ];

    echo json_encode($response);
?>