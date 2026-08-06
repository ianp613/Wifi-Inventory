<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");

    if(strtolower($_SESSION["privileges"]) != "administrator"){
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
    $task_ = DB::all($task);

    foreach($task_ as $t){
        $update_user_id = false;
        $update_task_budy = false;
        if($t["user_id"] == $data["id"]){
            $update_user_id = true;
        }
        $ids = $t["task_budy"] != "-" ? explode("|", $t["task_budy"]) : [];
        if(in_array($data["id"],$ids)){
            $ids = array_diff($ids, [$data["id"]]);
            $update_task_budy = true;
        }

        if($update_user_id || $update_task_budy){
            $task__ = DB::prepare($task,$t["id"]);
            $task__->user_id = $update_user_id ? "-" : $t["user_id"];
            $task__->task_budy = $update_task_budy ? implode("|",$ids) : $t["task_budy"];
            $task__->task_budy = $task__->task_budy ? $task__->task_budy : "-";
            DB::update($task__);
        }
    }

    $user = new User;
    DB::delete($user,$data["id"]);

    $response = [
        "status" => true,
        "type" => "info",
        "message" => "User account has been deleted."
    ];

    echo json_encode($response);