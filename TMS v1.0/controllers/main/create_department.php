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

    $dept = new Department;
    $dept->dept_name = $data["dept_name"];
    $dept->dept_color = $data["dept_color"];
    DB::save($dept);

    $response = [
        "status" => true,
        "type" => "success",
        "message" => "Department has been created."
    ];

    echo json_encode($response);