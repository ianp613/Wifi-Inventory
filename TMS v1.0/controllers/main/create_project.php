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

    $project = new Project;
    $project->project_name = $data["project_name"];
    $project->color = $data["color"];
    $project->dept_id = $data["dept_id"];
    DB::save($project);

    $log = new Log;
    $log->search_code = "*_";
    $log->user_id = $_SESSION["userid"];
    $log->show_to = $_SESSION["privileges"] == "Administrator" ? "*_" : "*";
    $log->log = $_SESSION["fname"] . " added a project " . $project->project_name . ".";
    DB::save($log);

    $response = [
        "status" => true,
        "type" => "success",
        "message" => "Project has been created."
    ];

    error_log("hello");
    echo json_encode($response);