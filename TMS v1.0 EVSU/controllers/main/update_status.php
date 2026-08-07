<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    $task = new Task;
    $task = DB::prepare($task,$data["id"]);
    if($data["status"] == "todo"){
        $response = [
            "status" => false,
            "type" => "error",
            "message" => "Tasks can't be moved back to To Do."
        ];
        echo json_encode($response);
        exit;
    }
    if($data["status"] == "rectify"){
        $task->status = "todo";
        $task->rectify = "1";
        $message = "Task has been rectified, and status set to TO DO.";
    }else{
        $task->status = $data["status"];
        $message = "Task status has been updated.";
    }
    DB::update($task);

    $response = [
        "status" => true,
        "type" => "success",
        "message" => $message
    ];

    echo json_encode($response);