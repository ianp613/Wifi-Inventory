<?php
    session_start();
    header('Content-Type: application/json');
    include("../../includes.php");

    $log = new Logs;

    $log = $_SESSION["privileges"] == "Administrator" ? DB::all($log,"created_at","desc") : DB::where($log,"uid","=",$_SESSION["userid"],"created_at","desc");
    $response = [
        "status" => true,
        "logs" => $log
    ];

    echo json_encode($response);
?>