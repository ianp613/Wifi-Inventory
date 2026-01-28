<?php
    header('Content-Type: application/json');
    session_start();
    include("../../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);
    
    $task = new Task;
    $task = DB::find($task,$data["id"]);


    $response = [
        "task" => $task,
        "remarker_id" => [],
        "remarker" => [],
        "remarks" => []
    ];

    array_push($response["remarker_id"],$task[0]["cid"]);
    array_push($response["remarker_id"],$task[0]["aid"]);
    $buddies = explode("|",$task[0]["buddies"]);
    foreach ($buddies as $buddy) {
        array_push($response["remarker_id"],$buddy);
        $response["remarker_id"] = array_unique($response["remarker_id"]);
    }

    $user = new User;
    $response["remarker"] = DB::all($user);

    $remark = new Remark;
    $response["remarks"] = DB::where($remark,"tid","=",$data["id"]);
    
    echo json_encode($response);
?>
