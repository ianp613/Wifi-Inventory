<?php
    header('Content-Type: application/json');
    session_start();
    include("../../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);
    
    $task = new Task;
    if($data["location"] && $data["id"]){
        $task = DB::where2($task,"aid","=",$data["id"],"location","=",$data["location"]); 
    }elseif($data["id"] && !$data["location"]){
        $task = DB::where($task,"aid","=",$data["id"]);
    }elseif(!$data["id"] && $data["location"]){
        $task = DB::where($task,"location","=",$data["location"]);
    }else{
        $task = DB::all($task);    
    }
    
    $locations = json_decode(file_get_contents("../../../assets/files/task_location.json"));

    $response = [
        "pending" => [],
        "ongoing" => [],
        "accomplished" => [],
        "count" => count($task),
        "locations" => array_merge($locations->default,$locations->user_defined),
    ];

    foreach ($task as $t) {
        $t["status"] == "Pending" ? array_push($response["pending"],$t) : null;
        $t["status"] == "Ongoing" ? array_push($response["ongoing"],$t) : null;
        $t["status"] == "Accomplished" ? array_push($response["accomplished"],$t) : null;
    }

    echo json_encode($response);
?>
