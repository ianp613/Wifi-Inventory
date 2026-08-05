<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    $task = new Task;
    $task = DB::prepare($task,$data["id"]);
    $task->status = $data["status"];
    DB::update($task);

    $response = [
        "status" => true,
        "type" => "success",
        "message" => "Task status has been updated."
    ];

    echo json_encode($response);