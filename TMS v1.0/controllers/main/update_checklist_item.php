<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    $checklist = new ChecklistItem;
    $checklist = DB::prepare($checklist,$data["id"]);
    $checklist->is_done = $data["is_done"];
    DB::update($checklist);

    $task = new Task;
    $task_ = DB::prepare($task,$checklist->task_id);
    $task_->trigger_update = $task_->trigger_update == "ping" ? "pong" : "ping";
    DB::update($task_);

    $response = [
        "status" => true,
        "type" => "success",
        "message" => "Checklist has been updated."
    ];

    echo json_encode($response);