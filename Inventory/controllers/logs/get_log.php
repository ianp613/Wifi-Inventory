<?php
    session_start();
    header('Content-Type: application/json');
    include("../../includes.php");

    $data = json_decode(file_get_contents('php://input'), true);
    $log = new Logs;

    if($data["logs"] != "All"){
        $log = DB::where($log,"uid","=",$data["logs"],"created_at","desc");
    }else{
        $log = $_SESSION["privileges"] == "Administrator" ? DB::all($log,"created_at","desc") : DB::where($log,"uid","=",$_SESSION["userid"],"created_at","desc");
    }
    $response = [
        "status" => true,
        "logs" => $log
    ];

    echo json_encode($response);
?>