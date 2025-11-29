<?php
    include("get_ssid.php");
    session_start();

    $data = json_decode(file_get_contents('php://input'), true);
    $message = $data["message"];
    $command = ["show","get","add","remove","check"];
    $response = "Please specify your query.";

    $message_break = explode("\n",$message);
    if(count($message_break) > 1){
        if(in_array(strtolower($message_break[0]),$command)){

        }
    }

    echo json_encode($response);
    

    // echo json_encode(get_ssid::index()["status"]);
?>

