<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    $user = new User;
    $u = DB::prepare($user,$data["id"]);
    $u->fname = $data["fname"];
    $u->lname = $data["lname"];
    $u->privileges = $data["privileges"];
    $u->status = $data["status"];
    $u->dept_id = $data["dept_id"];
    DB::update($u);

    $response = [
        "status" => true,
        "type" => "success",
        "message" => "User account has been updated."
    ];

    echo json_encode($response);