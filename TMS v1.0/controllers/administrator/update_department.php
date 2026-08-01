<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");

    $data = json_decode(file_get_contents('php://input'), true);

    $department = new Department;
    $dept = DB::prepare($department,$data["id"]);
    $dept->dept_name = $data["dept_name"];
    $dept->dept_color = $data["dept_color"];
    DB::update($dept);

    $response = [
        "status" => true,
        "type" => "success",
        "message" => "Department has been updated."
    ];

    echo json_encode($response);