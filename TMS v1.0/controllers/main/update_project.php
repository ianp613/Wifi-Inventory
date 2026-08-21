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
    $p = DB::prepare($project,$data["id"]);
    $project_name_temp = $p->project_name;
    $project_color_temp = $p->color;
    $p->project_name = $data["project_name"];
    $p->color = $data["color"];
    $p->dept_id = $data["dept_id"];
    DB::update($p);

    $log = new Log;
    $log->user_id = $_SESSION["userid"];
    $log->show_to = $_SESSION["privileges"] == "Administrator" ? "*_" : "*";
    if($project_name_temp != $data["project_name"]){
        $log->log = $_SESSION["fname"] . " updated a project name from ".$project_name_temp." to " . $data["project_name"] . ".";
        DB::save($log);
    }
    if($project_color_temp != $data["color"]){
        $log->log = $_SESSION["fname"] . " updated the color of project ".$project_name_temp." from <button type=\"button\" class=\"swatch_log \" style=\"background:".$project_color_temp.";\" data-color=\"".$project_color_temp."\"></button> to  <button type=\"button\" class=\"swatch_log \" style=\"background:".$data["color"].";\" data-color=\"".$data["color"]."\"></button>";
        DB::save($log);
    }

    $response = [
        "status" => true,
        "type" => "success",
        "message" => "Project has been updated."
    ];

    echo json_encode($response);