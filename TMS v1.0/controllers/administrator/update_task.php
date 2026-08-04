<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    $task = new Task;
    $task = DB::prepare($task,$data["id"]);
    $task->title = $data["title"];
    $task->description = $data["description"];
    $task->project_id = $data["project_id"];
    $task->user_id = $data["user_id"];
    $task->priority = $data["priority"];
    $task->start_date = $data["start_date"];
    $task->due_date = $data["due_date"];
    DB::update($task);

    error_log(json_encode($data));

    $response = [
        "status" => true,
        "type" => "success",
        "message" => "Task has been updated."
    ];

    echo json_encode($response);