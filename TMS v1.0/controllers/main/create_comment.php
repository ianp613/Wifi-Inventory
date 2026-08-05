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

    $response = [
        "status" => true,
        "type" => "success",
        "message" => "Commnent has been posted."
    ];

    echo json_encode($response);