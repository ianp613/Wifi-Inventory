<?php
    header('Content-Type: application/json');
    session_start();
    include("../../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);
    $locations = json_decode(file_get_contents("../../../assets/files/task_location.json"));

    if($data["location"]) {
        $task = new Task;
        $task->cid = $_SESSION["user_id"];
        $task->aid = $data["id"];
        $task->location = $data["location"];
        $task->description = $data["description"];
        $task->note = $data["note"];
        $task->status = "Pending";
        $task->deadline = $data["deadline"];
        $task->attachment = $data["attachment"];
        $task->buddies = $data["buddies"];
        DB::save($task);

        if(!in_array($data["location"],$locations->default) && !in_array($data["location"],$locations->user_defined)){
            array_push($locations->user_defined,$data["location"]);
            file_put_contents("../../../assets/files/task_location.json", json_encode($locations, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }

        $response = [
            "status" => true,
            "type" => "success",
            "message" => "Task has been added."
        ];
    }else{
        $response = [
            "status" => false,
            "type" => "warning",
            "message" => "Please add location."
        ];
    }
    echo json_encode($response);
?>
