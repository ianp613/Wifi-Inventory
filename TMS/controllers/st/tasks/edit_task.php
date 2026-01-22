<?php
    header('Content-Type: application/json');
    session_start();
    include("../../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    if($data) {
        $task = new Task;
        $task = DB::prepare($task,$data["id"]);
        $task->description = $data["description"];
        $task->note = $data["note"];
        $task->deadline = $data["deadline"];
        $task->buddies = $data["buddies"];
        DB::update($task);

        $response = [
            "status" => false,
            "type" => "success",
            "message" => "Task has been updated.",
            "data" => $data
        ];
    }
    echo json_encode($response);
?>
