<?php
    header('Content-Type: application/json');
    session_start();
    include("../../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    $response = [
        "files" => $data["files"],
        "deleted_files" => [],
        "message" => "Temporary files has been deleted."
    ];

    $files = explode("+++",$data["files"]);
    array_shift($files);

    $dir = "../../../assets/uploads/task_file_attachments/";

    foreach ($files as $file) {
        $file_ = explode("==",$file);
        if(file_exists($dir.$file_[1])){
            unlink($dir.$file_[1]);
            array_push($response["deleted_files"],$file_[1]);   
        }
    }

    echo json_encode($response);
?>
