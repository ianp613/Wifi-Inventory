<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");

    if(strtolower($_SESSION["privileges"]) == "technician"){
        $response = [
            "status" => false,
            "type" => "error",
            "message" => "You do not have permission to perform this action."
        ];
        echo json_encode($response);
        exit;
    }
    
    $data = json_decode(file_get_contents('php://input'), true);

    $task = new Task;
    $attachment = new Attachment;
    $checklist = new ChecklistItem;
    $comment = new Comment;
    $project = new Project;

    $task_ = DB::where($task,"project_id","=",$data["id"]);
    foreach($task_ as $t){
        $att_ = DB::where($attachment,"task_id","=",$t["id"]);
        foreach($att_ as $at){
            if(is_file($at["file_path"])){
                unlink($at["file_path"]);
            }
            DB::delete($attachment,$at["id"]);
        }

        $check_ = DB::where($checklist,"task_id","=",$t["id"]);
        foreach($check_ as $ch){
            DB::delete($checklist,$ch["id"]);
        }

        $comment_ = DB::where($comment,"task_id","=",$t["id"]);
        foreach($comment_ as $cm){
            DB::delete($comment,$cm["id"]);
        }

        DB::delete($task,$t["id"]);
    }
    DB::delete($project,$data["id"]);

    $response = [
        "status" => true,
        "type" => "info",
        "message" => "Project has been deleted."
    ];

    echo json_encode($response);