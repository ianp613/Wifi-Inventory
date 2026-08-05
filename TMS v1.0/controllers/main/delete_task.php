<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    // Delete Comments
    $comment = new Comment;
    $com = DB::where($comment,"task_id","=",$data["id"]);
    foreach($com as $co_){
        DB::delete($comment,$co_["id"]);
    }

    // Delete Checklist
    $checklist = new ChecklistItem;
    $check = DB::where($checklist,"task_id","=",$data["id"]);
    foreach($check as $ch_){
        DB::delete($checklist,$ch_["id"]);
    }

    // Delete Attachment
    $attachment = new Attachment;
    $attach = DB::where($attachment,"task_id","=",$data["id"]);
    foreach($attach as $at_){
        if(is_file($at_["file_path"])){
            unlink($at_["file_path"]);
        }
        DB::delete($attachment,$at_["id"]);
    }

    $task = new Task;
    DB::delete($task,$data["id"]);

    $response = [
        "status" => true,
        "type" => "info",
        "message" => "Task has been deleted."
    ];

    echo json_encode($response);