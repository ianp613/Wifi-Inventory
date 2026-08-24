<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");
    
    $data = json_decode(file_get_contents('php://input'), true);

    $comment = new Comment;
    $comment->task_id = $data["task_id"];
    $comment->user_id = $_SESSION["userid"];
    $comment->comment_text = $data["comment_text"];
    DB::save($comment);

    $task = new Task;
    $task_ = DB::prepare($task,$comment->task_id);
    $task_->trigger_update = $task_->trigger_update == "ping" ? "pong" : "ping";
    DB::update($task_);
    
    $log = new Log;
    $log->search_code = $data["jo_code"];
    $log->user_id = $_SESSION["userid"];
    $log->show_to = $_SESSION["privileges"] == "Administrator" ? "*_" : "*";
    $log->log = $_SESSION["fname"] . " added a comment to task <span class=\"task_log\" data-show-task=\"".$data["task_id"]."\">" . $task->title . "</span>.";
    DB::save($log);

    $response = [
        "status" => true,
        "type" => "success",
        "message" => "Commnent has been posted."
    ];

    echo json_encode($response);