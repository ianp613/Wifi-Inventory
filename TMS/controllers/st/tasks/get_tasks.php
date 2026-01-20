<?php
    header('Content-Type: application/json');
    session_start();
    include("../../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);
    
    $task = new Task;
    $task = $data["id"] ? DB::where($task,"uid","=",$data["id"]) : DB::all($task);

    $response = [
        "pending" => [],
        "ongoing" => [],
        "accomplished" => [],
        "count" => count($task)
    ];

    foreach ($task as $t) {
        $t["status"] == "Pending" ? array_push($response["pending"],$t) : null;
        $t["status"] == "Ongoing" ? array_push($response["ongoing"],$t) : null;
        $t["status"] == "Accomplished" ? array_push($response["accomplished"],$t) : null;
    }

    echo json_encode($response);
?>
