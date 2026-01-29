<?php
    header('Content-Type: application/json');
    session_start();
    include("../../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    $response = [
        "file" => $data["file"],
        "deleted_file" => [],
        "message" => "Temporary file has been deleted."
    ];

    $dir = "../../../assets/uploads/task_file_attachments/";


    if(file_exists($dir.$data["file"])){
        unlink($dir.$data["file"]);
        array_push($response["deleted_file"],$data["file"]);   
    }


    echo json_encode($response);
?>
