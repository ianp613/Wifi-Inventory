<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    $task = new Task;
    $task = DB::prepare($task,$data["id"]);
    $status_temp = $task->status;
    if($data["status"] == "todo"){
        $response = [
            "status" => false,
            "type" => "error",
            "message" => "Tasks can't be moved back to To Do."
        ];
        echo json_encode($response);
        exit;
    }

    $log = new Log;
    $log->user_id = $_SESSION["userid"];
    $log->search_code = $task->jo_code;
    $log->show_to = $_SESSION["privileges"] == "Administrator" ? "*_" : "*";

    $status = [
        "todo" => "To Do",
        "progress" => "In Progress",
        "hold" => "On Hold",
        "done" => "Done"
    ];
    if($data["status"] == "rectify"){
        $task->status = "todo";
        $task->rectify = "1";
        $message = "Task has been rectified, and status set to TO DO.";
        $log->log = $_SESSION["fname"] . " set the task <span class=\"task_log\" data-show-task=\"".$data["id"]."\">" . $task->title . "</span> for correction and the status has been set to <span class=\"status-tag status-todo\">".$status[$task->status]."</span>.";
        DB::save($log);
    }else{
        $task->status = $data["status"];
        $message = "Task status has been updated.";
        $log->log = $_SESSION["fname"] . " set the status of task <span class=\"task_log\" data-show-task=\"".$data["id"]."\">" . $task->title . "</span> from <span class=\"status-tag status-".$status_temp."\">".$status[$status_temp]."</span> to <span class=\"status-tag status-".$data["status"]."\">".$status[$data["status"]]."</span>.";
        DB::save($log);
    }
    DB::update($task);



    $response = [
        "status" => true,
        "type" => "success",
        "message" => $message
    ];

    echo json_encode($response);