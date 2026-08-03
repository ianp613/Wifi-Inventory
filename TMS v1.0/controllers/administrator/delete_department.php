<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");
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

    echo json_encode($response);