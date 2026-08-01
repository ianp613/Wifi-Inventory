<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    $task = new Task;
    $t = DB::prepare($task,$data["id"]);
    $t->user_id = $data["user_id"];
    DB::update($t);

    error_log(json_encode($data));

    $response = [
        "status" => true,
        "type" => "success",
        "message" => "Task has been reassigned."
    ];

    echo json_encode($response);