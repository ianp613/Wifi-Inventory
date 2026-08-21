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

    $project = new Project;
    $project_ = DB::where($project,"dept_id","=",$data["id"]);

    foreach($project_ as $proj){
        $temp = DB::prepare($project,$proj["id"]);
        $temp->dept_id = "-";
        DB::update($temp);
    }

    $user = new User;
    $user_ = DB::where($user,"dept_id","=",$data["id"]);

    foreach($user_ as $use){
        $temp = DB::prepare($user,$use["id"]);
        $temp->dept_id = "-";
        DB::update($temp);
    }


    $dept = new Department;
    DB::delete($dept,$data["id"]);

    $response = [
        "status" => true,
        "type" => "info",
        "message" => "Department has been deleted."
    ];

    $log = new Log;
    $log->user_id = $_SESSION["userid"];
    $log->show_to = $_SESSION["privileges"] == "Administrator" ? "*_" : "*";
    $log->log = $_SESSION["fname"] . " deleted a site " . $data["dept_name"] . ".";
    DB::save($log);


    echo json_encode($response);