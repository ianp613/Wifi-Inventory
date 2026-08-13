<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    $task = new Task;
    $t = DB::prepare($task,$data["id"]);

    // Split, then strip empty/placeholder entries — otherwise the first-ever
    // reassignment on a task with no prior buddies leaves a stray "" or "-"
    // in the list, which crashes the frontend when it parseInt()'s it.
    $buddies_id = array_filter(explode("|", $t->task_budy), function($id){
        return $id !== "" && $id !== "-";
    });

    if(in_array($data["user_id"], $buddies_id)){
        $buddies_id = array_diff($buddies_id, [$data["user_id"]]);
    }

    array_push($buddies_id, $t->user_id);
    $buddies_id = array_unique($buddies_id);

    $t->user_id = $data["user_id"];
    $t->task_budy = $buddies_id ? implode("|", $buddies_id) : "-";

    DB::update($t);

    $response = [
        "status" => true,
        "type" => "success",
        "message" => "Task has been reassigned."
    ];

    echo json_encode($response);