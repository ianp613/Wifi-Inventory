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

    $department = new Department;
    $dept = DB::prepare($department,$data["id"]);
    $dept_name_temp = $dept->dept_name;
    $dept_color_temp = $dept->dept_color;
    $dept->dept_name = $data["dept_name"];
    $dept->dept_color = $data["dept_color"];
    DB::update($dept);

    $log = new Log;
    $log->show_to = $_SESSION["privileges"] == "Administrator" ? "*_" : "*";
    if($dept_name_temp != $data["dept_name"]){
        $log->log = $_SESSION["fname"] . " updated a site name from ".$dept_name_temp." to " . $data["dept_name"] . ".";
        DB::save($log);
    }
    if($dept_color_temp != $data["dept_color"]){
        $log->log = $_SESSION["fname"] . " updated a site color from ".$dept_color_temp." to " . $data["dept_color"] . ".";
        DB::save($log);
    }
    $response = [
        "status" => true,
        "type" => "success",
        "message" => "Department has been updated."
    ];

    echo json_encode($response);